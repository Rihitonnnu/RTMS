<?php

namespace App\Http\Controllers;

use App\Models\TargetTime;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 今週の合計時間、目標時間、今週の時間を計算するサービスを作ったほうがいいかも
        // とりあえずフォームで目標時間を保存してそれを表示するまで
        $userId = Auth::id();
        $targetTime = TargetTime::where('user_id', $userId)->first();

        return Inertia::render('Dashboard', compact('targetTime', 'userId'));
    }
}
