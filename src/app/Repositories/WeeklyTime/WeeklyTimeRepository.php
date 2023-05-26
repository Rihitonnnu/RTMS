<?php

namespace App\Repositories\WeeklyTime;

use App\Models\WeeklyTime;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class WeeklyTimeRepository implements WeeklyTimeRepositoryInterface
{
    private $weeklyTime;
    /**
     * @var App\Models\WeeklyTime
     */
    public function __construct(WeeklyTime $weeklyTime)
    {
        $this->weeklyTime = $weeklyTime;
    }

    /**
     * 週間研究時間を登録する
     *
     * @return void
     */
    public function store($researchTime): void
    {
        $userId = Auth::id();
        $createdweeklyTime = $this->weeklyTime->create([
            'user_id' => $userId,
            'research_time' => $researchTime,
        ]);
        User::find($userId)->fill(['weekly_time_id' => $createdweeklyTime->id])->save();
    }

    /**
     * 週間研究時間を加算して更新する
     *
     * @return bool
     */
    public function update($weeklyTime, $researchTime): bool
    {
        $updatedWeeklyTime = $weeklyTime->research_time + $researchTime;
        return $weeklyTime->fill(['research_time' => $updatedWeeklyTime])->save();
    }
}
