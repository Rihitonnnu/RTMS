<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    public function researches(): HasMany
    {
        return $this->hasMany(Research::class);
    }

    public function weeklyTime(): HasOne
    {
        return $this->hasOne(WeeklyTime::class);
    }

    /**
     * 現在記録中のtimesに紐付ける
     */
    public function currentResearch(): HasOne
    {
        return $this->hasOne(Research::class, 'id', 'research_id');
    }

    /**
     * 現在記録中のrestsに紐付ける
     */
    public function currentRest(): HasOne
    {
        return $this->hasOne('App\Models\Rest', 'id', 'rest_id');
    }

    /**
     * 今週の週間研究時間を紐付ける
     */
    public function currentWeeklyTime(): HasOne
    {
        return $this->hasOne('App\Models\WeeklyTime', 'id', 'weekly_time_id');
    }
}
