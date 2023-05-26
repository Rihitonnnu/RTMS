<?php

namespace App\Repositories\Rest;

use App\Models\Rest;
use Carbon\Carbon;

class RestRepository implements RestRepositoryInterface
{
    private $rest;
    /**
     * @var \App\Models\Rest
     */
    public function __construct(Rest $rest)
    {
        $this->rest = $rest;
    }

    /**
     * 休憩時間を登録する
     *
     * @param int $researchId
     * @return Rest
     */
    public function store(int $researchId): Rest
    {
        return $this->rest->create([
            'research_id' => $researchId,
            'start_time' => Carbon::now()
        ]);
    }

    /**
     * 休憩時間を更新する
     *
     * @param Rest $request
     * @return \App\Models\TargetTime
     */
    public function update(Rest $currentRest, $endTime): void
    {
        $currentRest->fill(['end_time' => $endTime])->save();
    }
}
