<?php

namespace App\Repositories\Rest;

use App\Models\Rest;
use Carbon\Carbon;

class RestRepository implements RestRepositoryInterface
{
    private $rest;
    /**
     * @param \App\Models\Rest $rest
     * @return void
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
     * @param Rest $currentRest
     * @param \Carbon\Carbon $endTime
     * @return bool
     */
    public function update(Rest $currentRest, \Carbon\Carbon $endTime): bool
    {
        return $currentRest->fill(['end_time' => $endTime])->save();
    }
}
