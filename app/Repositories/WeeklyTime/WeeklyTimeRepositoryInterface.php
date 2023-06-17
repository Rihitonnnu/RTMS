<?php

namespace App\Repositories\WeeklyTime;

use App\Models\WeeklyTime;

interface WeeklyTimeRepositoryInterface
{
    public function storeResearchTime(float $researchTime): bool;
    public function updateResearchTime(WeeklyTime $weeklyTime, float $researchTime): bool;
    public function storeRestTime(float $restTime): bool;
    public function updateRestTime(WeeklyTime $weeklyTime, float $restTime): bool;
}
