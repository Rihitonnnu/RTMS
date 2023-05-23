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
        'time_id',
        'rest_id',
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

    public function times()
    {
        return $this->hasMany(Time::class);
    }

    /**
     * 現在記録中のtimesに紐付ける
     *
     * @return void
     */
    public function currentTime()
    {
        return $this->hasOne('App\Models\Time', 'id', 'time_id');
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
}
