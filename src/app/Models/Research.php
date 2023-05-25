<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;

class Research extends Model
{
    use HasFactory;

    protected $table = 'researches';

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
            // ログで出力してあげるようにする
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
        $user = Db::select('select is_started from users where id=?', [$userId])[0];
        if (!$user->is_started) {
            return false;
        }

        DB::update('update users set is_started=false where users.id=?', [$userId]);
        DB::update('update researches set end_time=? where id=(select research_id from users where users.id=?)', [Carbon::now(), $userId]);
        return true;
    }
}
