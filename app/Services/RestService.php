<?php

namespace App\Services;

use App\Repositories\Rest\RestRepository;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use Carbon\Carbon;
use App\Repositories\WeeklyTime\WeeklyTimeRepository;
use App\Services\TimeBasedConversionService;
use App\Models\Research;
use App\Repositories\DailyTime\DailyTimeRepository;
use Illuminate\Support\Facades\Auth;

class RestService
{
    private $timeBasedConversionService;
    private $weeklyTimeRepository;
    private $dailyTimeRepository;
    private $restRepository;

    public function __construct(TimeBasedConversionService $timeBasedConversionService, WeeklyTimeRepository $weeklyTimeRepository, DailyTimeRepository $dailyTimeRepository, RestRepository $restRepository)
    {
        $this->timeBasedConversionService = $timeBasedConversionService;
        $this->weeklyTimeRepository = $weeklyTimeRepository;
        $this->dailyTimeRepository = $dailyTimeRepository;
        $this->restRepository = $restRepository;
    }

    /**
     * 休憩開始時間を登録する
     *
     * @param integer $researchId
     * @return bool
     * @throws Throwable
     */
    public function store(int $researchId)
    {
        return DB::transaction(function () use ($researchId) {
            $rest = $this->restRepository->store($researchId);

            $user = User::find(Auth::id());

            if ($user->is_rested) { // 開始時間が打刻されている場合はrollbackしてエラーメッセージを表示させる
                return false;
            }
            // ここもrepositoryで切り分け
            $user->fill(['is_rested' => true, 'rest_id' => $rest->id])->save();
            return true;
        });
    }

    /**
     * 休憩終了時間を登録する
     *
     * @param integer $researchId
     * @return bool
     */
    public function update(int $researchId)
    {
        return DB::transaction(function () use ($researchId) {
            $user = User::find(Auth::id());
            /** @var \App\Models\Research */
            $research = Research::find($researchId);
            if (!$research->user->is_rested) {
                return false;
            }

            $currentRest = $research->user->currentRest;
            // 休憩開始・終了時間
            $startTime = $currentRest->start_time;
            $endTime = Carbon::now();

            $this->restRepository->update($currentRest, $endTime);
            // $research->user->currentRest->fill(['end_time' => $endTime])->save();
            // あとで切り分け対応
            $research->user->fill(['is_rested' => false])->save();

            // 時間の単位を(H)に変換し、今週の休憩時間に加算
            $restTime = $this->timeBasedConversionService->convertTimeToHour($startTime, $endTime);

            // 今週の初めと終わりの日を取得
            $weekFirst = Carbon::today()->startOfWeek();
            $weekLast = Carbon::today()->addWeek();
            $createdWeeklyTime = new Carbon($user?->currentWeeklyTime?->created_at);

            // 前回登録したweekly_timesがない、もしくは先週のものであれば新しく作成し、そうでなければ前回のweekly_timesのrest_timeを取得し、更新する
            if (is_null($user?->currentWeeklyTime) || ($createdWeeklyTime->lt($weekFirst) || $createdWeeklyTime->gt($weekLast))) {
                $this->weeklyTimeRepository->storeRestTime($restTime);
            } else {
                $weeklyTime = $user->currentWeeklyTime;
                $this->weeklyTimeRepository->updateRestTime($weeklyTime, $restTime);
            }

            $createdDailyTime = new Carbon($user?->currentDailyTime?->created_at);
            $dayFirst = Carbon::today()->startOfDay();
            $dayLast = Carbon::today()->startOfDay()->addDay();

            // 前回登録したdaily_timeがない、もしくは先週のものであれば新しく作成し、そうでなければ前回のdaily_timesのresearch_timeを取得し、更新する
            if (is_null($user?->currentDailyTime) || ($createdDailyTime->lt($dayFirst) || $createdDailyTime->gt($dayLast))) {
                $this->dailyTimeRepository->storeRestTime($restTime);
            } else {
                /** @var \App\Models\DailyTime */
                $dailyTime = $user->currentDailyTime;
                $this->dailyTimeRepository->updateRestTime($dailyTime, $restTime);
            }
            return true;
        });
    }
}
