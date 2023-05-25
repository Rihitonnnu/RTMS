<?php

namespace App\Http\Controllers;

use App\Models\Research;
use App\Models\Time;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ResearchController extends Controller
{
    /**
     * @param Time $time
     */
    public function __construct(Research $research)
    {
        $this->research = $research;
    }

    /**
     * 開始時間を登録
     *
     * @return void
     */
    public function storeStartTime()
    {
        $userId = Auth::id();
        $result = $this->research->storeTime($userId);
        if ($result) {
            return redirect('dashboard')->with('flash_message', '研究開始時間を打刻しました');
        } else { // 研究開始ボタンを2回連続で押した場合は、すでに開始していることをエラーメッセージで表示
            return redirect('dashboard')->with('flash_error_message', 'すでに開始しています');
        }
    }

    /**
     * 終了時間を登録
     */
    public function storeEndTime()
    {
        $userId = Auth::id();
        $user = User::find($userId);

        // 休憩を終了せずに研究を終了した場合にエラーメッセージを表示
        if (is_null($user->currentRest->end_time)) {
            return redirect('dashboard')->with('flash_error_message', '休憩を終了してください');
        }
        $result = $this->research->updateTime($userId);
        if ($result) {
            return redirect('dashboard')->with('flash_message', '研究終了時間を打刻しました');
        } else { // 研究を開始せずに終了しようとした場合にエラーメッセージを表示
            return redirect('dashboard')->with('flash_error_message', 'まだ開始していません');
        }
    }
}
