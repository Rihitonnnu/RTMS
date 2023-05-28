<?php

namespace App\Http\Controllers;

use App\Models\TargetTime;
use Illuminate\Http\Request;
use App\Repositories\TargetTime\TargetTimeRepository as TargetTimeRepository;
use Inertia\Inertia;

class TargetTimeController extends Controller
{
    private $targetTimeRepository;

    public function __construct(TargetTimeRepository $targetTimeRepository)
    {
        $this->targetTimeRepository = $targetTimeRepository;
    }

    /**
     * 目標時間の登録
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->targetTimeRepository->store($request);
        return redirect('dashboard')->with('flash_message', '今週の研究目標時間を登録しました');
    }

    /**
     * 目標時間編集画面へ
     *
     * @param integer $targetTimeId
     * @return \Inertia\Response
     */
    public function edit(int $targetTimeId): \Inertia\Response
    {
        $targetTime = TargetTime::find($targetTimeId);
        return Inertia::render('TimeManagement/TargetTimeEdit', compact('targetTime'));
    }

    /**
     * 目標時間の更新
     *
     * @param Request $request
     * @param integer $targetTimeId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $targetTimeId)
    {
        $this->targetTimeRepository->update($request, $targetTimeId);
        return redirect('dashboard')->with('flash_message', '目標時間を更新しました。');
    }
}
