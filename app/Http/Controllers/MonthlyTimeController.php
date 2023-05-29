<?php

namespace App\Http\Controllers;

use App\Models\DailyTime;
use App\Services\MonthlyTimeService;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        $userId = Auth::id();
        $firstDayThisMonth = Carbon::now()->startOfMonth();
        $endDayThisMonth = Carbon::now()->endOfMonth();

        $thisMonthInfos = DailyTime::where('user_id', $userId)
            ->where('date', '>=', $firstDayThisMonth->format('Y/m/d'))
            ->where('date', '<=', $endDayThisMonth->format('Y/m/d'))
            ->orderBy('date', 'asc')
            ->get();
        return Inertia::render('MonthlyTime/MonthlyTimeListPage', compact('thisMonthInfos'));
    }
}
