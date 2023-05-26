<?php

namespace App\Repositories\WeeklyTime;

use Illuminate\Http\Request;

interface WeeklyTimeRepositoryInterface
{
    public function store(Request $request): void;
    public function update($weeklyTime, $researchTime): bool;
}
