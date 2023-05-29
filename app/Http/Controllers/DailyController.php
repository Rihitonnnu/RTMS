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
        /** @var float */
        $researchTime = $request->input('research_time');
        /** @var float */
        $restTime = $request->input('rest_time');
        $dailyTime = DailyTime::find($dailyTimeId);
        $this->dailyTimeRepository->updateDailyTime($researchTime, $restTime, $dailyTime);
        return to_route('monthlyTime.index')->with('flash_message', '研究時間を修正しました');
    }

    public function destroy(int $dailyTimeId)
    {
        $this->dailyTimeRepository->destroyDailyTime(DailyTime::find($dailyTimeId));
        return to_route('monthlyTime.index')->with('flash_message', '研究時間を削除しました');
    }
}
