<?php

namespace App\Http\Controllers;

use App\Models\Time;
use Illuminate\Support\Facades\Auth;

class TimeController extends Controller
{
    /**
     * @param Time $time
     */
    public function __construct(Time $time)
    {
        $this->time = $time;
    }

    /**
     * 研究開始時間を登録
     *
     * @return void
     */
    public function storeStartTime()
    {
        $userId = Auth::id();
        $this->time->storeTime($userId);
        return redirect('dashboard')->with('flash_message', '開始時間を打刻しました');
    }
}
