<?php

namespace App\Repositories\DailyTime;

use App\Models\DailyTime;

interface DailyTimeRepositoryInterface
{
    public function storeResearchTime(float $researchTime): bool;
    public function updateResearchTime(DailyTime $dailyTime, float $researchTime): bool;
    public function storeRestTime(float $restTime): bool;
    public function updateRestTime(DailyTime $dailyTime, float $restTime): bool;
    public function updateDailyTime(float $researchTime, float $restTime, DailyTime $dailyTime): bool;
    public function destroyDailyTime(DailyTime $dailyTime): bool;
    public function storeNotRegisteredDay($firstDayThisMonth, $now);
}
