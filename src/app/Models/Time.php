<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;

class Time extends Model
{
    use HasFactory;

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
            $time = $this->create([
                'user_id' => $userId,
                'start_time' => Carbon::now()
            ]);
            $user = User::find($userId);

            if ($user->is_started) { // 開始時間が打刻されている場合はrollbackしてエラーメッセージを表示させる
                DB::rollBack();
                return false;
            }
            $user->fill(['is_started' => true, 'time_id' => $time->id])->save();
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
    public function updateTime(int $userId)
    {
        $user = User::find($userId);
        if (!$user->is_started) {
            return false;
        }
        // ここもトランザクション加えたほうがいいかも
        $user->currentTime->fill(['end_time' => Carbon::now()])->save();
        return $user->fill(['is_started' => false])->save();
    }
}
