<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;

class Rest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'time_id',
        'start_time',
        'end_time',
    ];

    public function time()
    {
        return $this->belongsTo(Time::class);
    }

    /**
     * 開始時間を登録する
     *
     * @param integer $userId
     * @return boolean
     */
    public function storeTime(int $timeId)
    {
        try {
            DB::beginTransaction();
            $rest = $this->create([
                'time_id' => $timeId,
                'start_time' => Carbon::now()
            ]);
            $time = Time::find($timeId);

            if ($time->user->is_rested) { // 開始時間が打刻されている場合はrollbackしてエラーメッセージを表示させる
                DB::rollBack();
                return false;
            }
            $time->user->fill(['is_rested' => true, 'rest_id' => $rest->id])->save();
            DB::commit();
            return true;
        } catch (Throwable $e) {
            DB::rollBack();
        }
    }

    /**
     * 終了時間を登録する
     *
     * @param integer $userId
     * @return boolean
     */
    public function updateTime(int $timeId)
    {
        $time = Time::find($timeId);
        if (!$time->user->is_rested) {
            return false;
        }
        // ここもトランザクション加えたほうがいいかも
        $time->user->currentRest->fill(['end_time' => Carbon::now()])->save();
        return $time->user->fill(['is_rested' => false])->save();
    }
}
