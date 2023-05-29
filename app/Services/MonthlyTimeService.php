<?php

namespace App\Services;

use App\Repositories\DailyTime\DailyTimeRepository;
use Carbon\Carbon;
use App\Models\DailyTime;
use Illuminate\Support\Facades\Auth;

class MonthlyTimeService
{
    private $dailyTimeRepository;
    /**
     * @param DailyTimeRepository $dailyTimeRepository
     */
    public function __construct(DailyTimeRepository $dailyTimeRepository)
    {
        $this->dailyTimeRepository = $dailyTimeRepository;
    }

    /**
     * 今月の研究時間に関する情報を取得
     *
     * @return \App\Models\DailyTime
     */
    public function getThisMonthInfos()
    {
        $userId = Auth::id();
        $firstDayThisMonth = Carbon::now()->startOfMonth();
        $endDayThisMonth = Carbon::now()->endOfMonth();

        // 今月の研究時間の情報を取得
        return DailyTime::where('user_id', $userId)
            ->where('date', '>=', $firstDayThisMonth->format('Y/m/d'))
            ->where('date', '<=', $endDayThisMonth->format('Y/m/d'))
            ->orderBy('date', 'asc')
            ->get();
    }

    /**
     * 今月の研究時間を取得
     *
     * @param \App\Models\DailyTime $thisMonthInfos
     * @return float
     */
    public function getThisMonthResearchTime($thisMonthInfos): float
    {
        $thisMonthResearchTime = 0;
        foreach ($thisMonthInfos as $thisMonthInfo) {
            $thisMonthResearchTime += $thisMonthInfo->research_time - $thisMonthInfo->rest_time;
        }
        return $thisMonthResearchTime;
    }

    public function storeNotRegisteredDay(): void
    {
        $firstDayThisMonth = Carbon::now()->startOfMonth();
        $now = Carbon::now()->startOfDay();

        $this->dailyTimeRepository->storeNotRegisteredDay($firstDayThisMonth, $now);
    }
}
