<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ResearchService;
use Illuminate\Support\Facades\Auth;

class ResearchController extends Controller
{
    private $researchService;
    /**
     * @param ResearchService $researchService
     */
    public function __construct(ResearchService $researchService)
    {
        $this->researchService = $researchService;
    }

    /**
     * 開始時間を登録
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeStartTime()
    {
        $userId = Auth::id();
        $result = $this->researchService->store($userId);
        if ($result) {
            return redirect('dashboard')->with('flash_message', '研究開始時間を打刻しました');
        } else { // 研究開始ボタンを2回連続で押した場合は、すでに開始していることをエラーメッセージで表示
            return redirect('dashboard')->with('flash_error_message', 'すでに開始しています');
        }
    }

    /**
     * 終了時間を登録
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeEndTime()
    {
        $userId = Auth::id();
        $user = User::find($userId);

        // 休憩を終了せずに研究を終了した場合にエラーメッセージを表示
        if ($user->is_rested) {
            return redirect('dashboard')->with('flash_error_message', '休憩を終了してください');
        }
        $result = $this->researchService->update($userId);
        if ($result) {
            return redirect('dashboard')->with('flash_message', '研究終了時間を打刻しました');
        } else { // 研究を開始せずに終了しようとした場合にエラーメッセージを表示
            return redirect('dashboard')->with('flash_error_message', 'まだ開始していません');
        }
    }
}
