<?php

namespace App\Http\Controllers;

use App\Models\DailyTime;
use App\Repositories\DailyTime\DailyTimeRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DailyController extends Controller
{
    private $dailyTimeRepository;

    public function __construct(DailyTimeRepository $dailyTimeRepository)
    {
        $this->dailyTimeRepository = $dailyTimeRepository;
    }

    public function edit(int $dailyTimeId)
    {
        $dailyTime = DailyTime::where('id', $dailyTimeId)->first();
        return Inertia::render('DailyTime/DailyTimeEdit', compact('dailyTime'));
    }

    public function update(Request $request, int $dailyTimeId)
    {
        $researchTime = $request->input('research_time');
        $restTime = $request->input('rest_time');
        $dailyTime = DailyTime::find($dailyTimeId);
        $this->dailyTimeRepository->updateDailyTime($researchTime, $restTime, $dailyTime);
        return to_route('monthlyTime.index');
    }

    public function destroy(int $dailyTimeId)
    {
        $this->dailyTimeRepository->destroyDailyTime(DailyTime::find($dailyTimeId));
        return to_route('monthlyTime.index');
    }
}
