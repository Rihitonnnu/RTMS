<?php

namespace App\Http\Controllers;

use App\Services\MonthlyTimeService;
use Inertia\Inertia;

class MonthlyTimeController extends Controller
{
    private $monthlyTimeService;

    public function __construct(MonthlyTimeService $monthlyTimeService)
    {
        $this->monthlyTimeService = $monthlyTimeService;
    }

    public function index()
    {
        $this->monthlyTimeService->storeNotRegisteredDay();
        $thisMonthInfos = $this->monthlyTimeService->getThisMonthInfos();
        $thisMonthResearchTime = $this->monthlyTimeService->getThisMonthResearchTime($thisMonthInfos);

        return Inertia::render('MonthlyTime/MonthlyTimeListPage', compact('thisMonthInfos', 'thisMonthResearchTime'));
    }
}
