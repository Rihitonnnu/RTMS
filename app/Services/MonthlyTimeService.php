<?php

namespace App\Services;

use App\Repositories\DailyTime\DailyTimeRepository;
use Carbon\Carbon;

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

    public function storeNotRegisteredDay(): void
    {
        $firstDayThisMonth = Carbon::now()->startOfMonth();
        $now = Carbon::now()->startOfDay();

        $this->dailyTimeRepository->storeNotRegisteredDay($firstDayThisMonth, $now);
    }
}
