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
        // 今週の合計時間、目標時間、今週の時間を計算するサービスを作ったほうがいいかも
        $userId = Auth::id();
        // 今週の目標時間を取得
        $targetTime = TargetTime::where('user_id', $userId)->first();

        // 今週の研究時間を取得
        $weeklyTime = WeeklyTime::where('user_id', $userId)->first()->research_time;

        return Inertia::render('Dashboard', compact('targetTime', 'userId', 'weeklyTime'));
    }
}
