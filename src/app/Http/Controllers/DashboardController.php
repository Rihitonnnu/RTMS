<?php

namespace App\Http\Controllers;

use App\Models\TargetTime;
use App\Models\WeeklyTime;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // ここはサービスで切り出さないほうがよさげ？
        $userId = Auth::id();

        // 今週の目標時間を取得
        $targetTime = TargetTime::where('user_id', $userId)->first();

        // 今週の研究・休憩時間を取得
        $weeklyResearchTime = WeeklyTime::where('user_id', $userId)->first()->research_time;
        $weeklyRestTime = WeeklyTime::where('user_id', $userId)->first()->rest_time;
        if ($weeklyRestTime < $weeklyResearchTime) {
            // 休憩時間を抜いた研究時間
            $weeklyTime = $weeklyResearchTime - $weeklyRestTime;
        } else {
            $weeklyTime = 0;
        }

        return Inertia::render('Dashboard', compact('targetTime', 'weeklyResearchTime', 'weeklyTime'));
    }
}
