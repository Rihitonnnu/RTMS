<?php

namespace App\Repositories\Research;

use App\Models\TargetTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResearchRepository implements ResearchRepositoryInterface
{
    private $targetTime;
    /**
     * @param \App\Models\TargetTime $targetTime
     * @return void
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
     * @return bool
     */
    public function update(Request $request, int $targetTimeId): bool
    {
        $time = $request->input('time');

        return $this->targetTime::find($targetTimeId)->fill(['time' => $time])->save();;
    }
}
