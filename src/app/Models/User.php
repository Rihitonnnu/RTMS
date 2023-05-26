<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'research_id',
        'rest_id',
        'weekly_time_id',
        'is_started',
        'is_rested',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function researches()
    {
        return $this->hasMany(Time::class);
    }

    public function weeklyTime()
    {
        return $this->hasOne(weeklyTime::class);
    }

    /**
     * 現在記録中のtimesに紐付ける
     *
     * @return void
     */
    public function currentResearch()
    {
        return $this->hasOne(Research::class, 'id', 'research_id');
    }

    /**
     * 現在記録中のrestsに紐付ける
     *
     * @return void
     */
    public function currentRest()
    {
        return $this->hasOne('App\Models\Rest', 'id', 'rest_id');
    }

    /**
     * 今週の週間研究時間を紐付ける
     *
     * @return void
     */
    public function currentWeeklyTime()
    {
        return $this->hasOne('App\Models\WeeklyTime', 'id', 'weekly_time_id');
    }
}
