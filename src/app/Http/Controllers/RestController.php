<?php

namespace App\Http\Controllers;

use App\Models\Rest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RestController extends Controller
{
    public function __construct(Rest $rest)
    {
        $this->rest = $rest;
    }

    public function storeStartTime()
    {
        $user = User::find(Auth::id());
        if (is_null($user->currentResearch)) {
            return redirect('dashboard')->with('flash_error_message', '研究を開始してください');
        }
        $result = $this->rest->storeTime($user->currentResearch->id);
        if ($result) {
            return redirect('dashboard')->with('flash_message', '休憩開始時間を打刻しました');
        } else {
            return redirect('dashboard')->with('flash_error_message', 'すでに開始しています');
        }
    }

    /**
     * 終了時間を登録
     */
    public function storeEndTime()
    {
        $user = User::find(Auth::id());
        $result = $this->rest->updateTime($user->currentResearch->id);
        if ($result) {
            return redirect('dashboard')->with('flash_message', '休憩終了時間を打刻しました');
        } else {
            return redirect('dashboard')->with('flash_error_message', 'まだ開始していません');
        }
    }
}
