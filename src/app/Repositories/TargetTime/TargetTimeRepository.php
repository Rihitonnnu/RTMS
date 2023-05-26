<?php

namespace App\Repositories\TargetTime;

use App\Models\TargetTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TargetTimeRepository implements TargetTimeRepositoryInterface
{
    private $targetTime;
    /**
     * @var App\Models\TargetTime
     */
    public function __construct(TargetTime $targetTime)
    {
        $this->targetTime = $targetTime;
    }

    /**
     * 目標時間を登録する
     *
     * @param Request $request
     * @return TargetTime
     */
    public function store(Request $request): TargetTime
    {
        $time = $request->input('time');

        $userId = Auth::id();
        return $this->targetTime->create([
            'user_id' => $userId,
            'time' => $time
        ]);
    }

    /**
     * 目標時間を更新する
     *
     * @param Request $request
     * @return \App\Models\TargetTime
     */
    public function update(Request $request, int $targetTimeId): void
    {
        $time = $request->input('time');

        $this->targetTime::find($targetTimeId)->fill(['time' => $time])->save();;
    }
}
