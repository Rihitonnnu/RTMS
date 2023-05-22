<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     * @return void
     */
    public function storeTime(int $userId)
    {
        $this->create([
            'user_id' => $userId,
            'start_time' => Carbon::now()
        ]);
    }
}
