<?php

namespace App\Repositories\WeeklyTime;

use App\Models\WeeklyTime;

interface WeeklyTimeRepositoryInterface
{
    public function storeResearchTime(float $researchTime): void;
    public function updateResearchTime(WeeklyTime $weeklyTime, float $researchTime): bool;
    public function storeRestTime(float $restTime): void;
    public function updateRestTime(WeeklyTime $weeklyTime, float $restTime): bool;
}
