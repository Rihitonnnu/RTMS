<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\RestService;
use Illuminate\Support\Facades\Auth;

class RestController extends Controller
{
    private $restService;

    /**
     * @param RestService $restService
     * @return void
     */
    public function __construct(RestService $restService)
    {
        $this->restService = $restService;
    }

    /**
     * 休憩開始時間を登録
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeStartTime()
    {
        $user = User::find(Auth::id());
        if ((!$user->is_started)) { // 研究を開始せずに休憩を開始しようとした場合
            return redirect('dashboard')->with('flash_error_message', '研究を開始してください');
        }
        $result = $this->restService->store($user->currentResearch->id);
        if ($result) {
            return redirect('dashboard')->with('flash_message', '休憩開始時間を打刻しました');
        } else { // 休憩開始ボタンを2回連続で押した場合
            return redirect('dashboard')->with('flash_error_message', 'すでに開始しています');
        }
    }

    /**
     * 休憩終了時間を登録
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeEndTime()
    {
        $user = User::find(Auth::id());
        if (is_null($user->currentResearch)) { // 研究を開始せずに休憩を終了しようとした場合
            return redirect('dashboard')->with('flash_error_message', '研究をまだ開始していません');
        }
        $result = $this->restService->update($user->currentResearch->id);
        if ($result) {
            return redirect('dashboard')->with('flash_message', '休憩終了時間を打刻しました');
        } else { // 休憩をまだ開始していない場合
            return redirect('dashboard')->with('flash_error_message', 'まだ開始していません');
        }
    }
}
