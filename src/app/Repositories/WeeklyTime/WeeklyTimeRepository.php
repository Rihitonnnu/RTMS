<?php

namespace App\Repositories\WeeklyTime;

use App\Models\WeeklyTime;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class WeeklyTimeRepository implements WeeklyTimeRepositoryInterface
{
    private $weeklyTime;
    /**
     * @param \App\Models\WeeklyTime $weeklyTime
     * @return void
     */
    public function __construct(WeeklyTime $weeklyTime)
    {
        $this->weeklyTime = $weeklyTime;
    }

    /**
     * 週間研究時間を登録する
     *
     * @param float $researchTime
     * @return void
     */
    public function storeResearchTime(float $researchTime): void
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
     * @param \App\Models\WeeklyTime $weeklyTime
     * @param float $researchTime
     * @return bool
     */
    public function updateResearchTime(WeeklyTime $weeklyTime, float $researchTime): bool
    {
        $updatedWeeklyTime = $weeklyTime->research_time + $researchTime;
        return $weeklyTime->fill(['research_time' => $updatedWeeklyTime])->save();
    }

    /**
     * 週間休憩時間を登録する
     *
     * @param float $restTime
     * @return void
     */
    public function storeRestTime(float $restTime): void
    {
        $userId = Auth::id();
        $createdweeklyTime = $this->weeklyTime->create([
            'user_id' => $userId,
            'rest_time' => $restTime,
        ]);
        User::find($userId)->fill(['weekly_time_id' => $createdweeklyTime->id])->save();
    }

    /**
     * 週間休憩時間を加算して更新する
     * 
     * @param \App\Models\WeeklyTime $weeklyTime
     * @param float $restTime
     * @return bool
     */
    public function updateRestTime(WeeklyTime $weeklyTime, float $restTime): bool
    {
        $updatedWeeklyTime = $weeklyTime->research_time + $restTime;
        return $weeklyTime->fill(['rest_time' => $updatedWeeklyTime])->save();
    }
}
