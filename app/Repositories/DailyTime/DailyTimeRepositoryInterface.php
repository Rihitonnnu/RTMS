<?php

namespace App\Repositories\DailyTime;

use App\Models\DailyTime;

interface DailyTimeRepositoryInterface
{
    public function storeResearchTime(float $researchTime): void;
    public function updateResearchTime(DailyTime $dailyTime, float $researchTime): bool;
    public function storeRestTime(float $restTime): void;
    public function updateRestTime(DailyTime $dailyTime, float $restTime): bool;
    public function updateDailyTime(float $researchTime, float $restTime, DailyTime $dailyTime);
    public function destroyDailyTime(DailyTime $dailyTime);
    public function storeNotRegisteredDay($firstDayThisMonth, $now);
}
