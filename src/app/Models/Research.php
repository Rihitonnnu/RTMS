<?php

namespace App\Models;

use App\Repositories\WeeklyTime\WeeklyTimeRepository;
use App\Services\TimeBasedConversionService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class Research extends Model
{
    use HasFactory;

    protected $table = 'researches';

    private $timeBasedConversionService;
    private $weeklyTimeRepository;

    public function __construct(TimeBasedConversionService $timeBasedConversionService, WeeklyTimeRepository $weeklyTimeRepository)
    {
        $this->timeBasedConversionService = $timeBasedConversionService;
        $this->weeklyTimeRepository = $weeklyTimeRepository;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 開始時間を登録する
     *
     * @param integer $userId
     * @return boolean
     */
    public function storeTime(int $userId)
    {
        try {
            DB::beginTransaction();
            DB::insert('insert into researches (user_id,start_time) values (?,?)', [$userId, Carbon::now()]);

            $user = DB::select('select * from users where id=?', [$userId]);
            $research = DB::select('select id from researches where user_id=? order by id desc', [$userId])[0];

            if ($user[0]->is_started) { // 開始時間が打刻されている場合はrollbackしてエラーメッセージを表示させる
                DB::rollBack();
                return false;
            }
            DB::update('update users set is_started=true,research_id=? where id=?', [$research->id, $userId]);
            DB::commit();
            return true;
        } catch (Throwable $e) {
            Log::debug($e);
            DB::rollBack();
        }
    }

    /**
     * 終了時間を登録する
     *
     * @param integer $userId
     * @return boolean
     */
    public function updateTime(int $userId)
    {
        try {
            DB::beginTransaction();

            $user = User::find($userId);
            if (!$user->is_started) {
                return false;
            }

            DB::update('update users set is_started=false where users.id=?', [$userId]);
            $endTime = Carbon::now();
            DB::update('update researches set end_time=? where id=(select research_id from users where users.id=?)', [$endTime, $userId]);

            $startTime = new Carbon(Db::select('select start_time from researches where id=(select research_id from users where users.id=?)', [$userId])[0]->start_time);

            // 時間の単位を(H)に変換し今週の研究時間に加算
            $researchTime = $this->timeBasedConversionService->convertTimeToHour($startTime, $endTime);

            //研究時間を登録・更新する処理　1週間に入っているのか新たに更新する必要があるのかどうかの分岐
            // ここで前回登録していたweeklytimeを取得
            $weekFirst = Carbon::today()->startOfWeek();
            $weekLast = Carbon::today()->addWeek(1);
            $createdWeeklyTime = new Carbon($user?->currentWeeklyTime?->created_at);

            // 前回登録した週間研究時間が先週のものであれば新しく作成し、そうでなければ前回の週間研究時間を取得し、更新する
            if (is_null($user?->currentWeeklyTime) || ($createdWeeklyTime->lt($weekFirst) || $createdWeeklyTime->gt($weekLast))) {
                $this->weeklyTimeRepository->store($researchTime);
            } else {
                $weeklyTime = $user->currentWeeklyTime;
                $this->weeklyTimeRepository->update($weeklyTime, $researchTime);
            }

            DB::commit();
            return true;
        } catch (Throwable $e) {
            Log::debug($e);
            DB::rollBack();
        }
    }
}
