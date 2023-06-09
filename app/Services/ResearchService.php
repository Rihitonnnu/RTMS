<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Repositories\DailyTime\DailyTimeRepository;
use App\Repositories\WeeklyTime\WeeklyTimeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ResearchService
{
    private $weeklyTimeRepository;
    private $dailyTimeRepository;
    private $timeBasedConversionService;

    public function __construct(TimeBasedConversionService $timeBasedConversionService, WeeklyTimeRepository $weeklyTimeRepository, DailyTimeRepository $dailyTimeRepository)
    {
        $this->timeBasedConversionService = $timeBasedConversionService;
        $this->weeklyTimeRepository = $weeklyTimeRepository;
        $this->dailyTimeRepository = $dailyTimeRepository;
    }

    /**
     * 研究開始時間を登録する
     *
     * @param integer $userId
     * @return bool
     */
    public function store(int $userId)
    {
        return DB::transaction(function () use ($userId) {
            DB::insert('insert into researches (user_id,start_time) values (?,?)', [$userId, Carbon::now()]);

            $user = DB::select('select * from users where id=?', [$userId]);
            $research = DB::select('select id from researches where user_id=? order by id desc', [$userId])[0];

            if ($user[0]->is_started) { // 開始時間が打刻されている場合はrollbackしてエラーメッセージを表示させる
                DB::rollBack();
                return false;
            }
            DB::update('update users set is_started=true,research_id=? where id=?', [$research->id, $userId]);
            return true;
        }, 2);
    }

    /**
     * 研究終了時間を登録する
     *
     * @param integer $userId
     * @return bool
     */
    public function update(int $userId)
    {
        return DB::transaction(function () use ($userId) {
            $user = User::find($userId);
            if (!$user->is_started) {
                return false;
            }

            DB::update('update users set is_started=false where users.id=?', [$userId]);
            $endTime = Carbon::now();
            DB::update('update researches set end_time=? where id=(select research_id from users where users.id=?)', [$endTime, $userId]);

            $startTime = new Carbon(Db::select('select start_time from researches where id=(select research_id from users where users.id=?)', [$userId])[0]->start_time);

            // 時間の単位を(H)に変換
            $researchTime = $this->timeBasedConversionService->convertTimeToHour($startTime, $endTime);

            //研究時間を登録・更新する処理　1週間に入っているのか新たに更新する必要があるのかどうかの分岐
            $weekFirst = Carbon::today()->startOfWeek();
            $weekLast = Carbon::today()->addWeek();
            $createdWeeklyTime = new Carbon($user?->currentWeeklyTime?->created_at);

            // 前回登録したweekly_timesがない、もしくは先週のものであれば新しく作成し、そうでなければ前回のweekly_timesのresearch_timeを取得し、今週の研究時間に加算した上で更新する
            if (is_null($user?->currentWeeklyTime) || ($createdWeeklyTime->lt($weekFirst) || $createdWeeklyTime->gt($weekLast))) {
                $this->weeklyTimeRepository->storeResearchTime($researchTime);
            } else {
                /** @var \App\Models\WeeklyTime */
                $weeklyTime = $user->currentWeeklyTime;
                $this->weeklyTimeRepository->updateResearchTime($weeklyTime, $researchTime);
            }

            $createdDailyTime = new Carbon($user?->currentDailyTime?->created_at);
            $dayFirst = Carbon::today()->startOfDay();
            $dayLast = Carbon::today()->startOfDay()->addDay();

            // 前回登録したdaily_timeがない、もしくは先週のものであれば新しく作成し、そうでなければ前回のdaily_timesのresearch_timeを取得し、更新する
            if (is_null($user?->currentDailyTime) || ($createdDailyTime->lt($dayFirst) || $createdDailyTime->gt($dayLast))) {
                $this->dailyTimeRepository->storeResearchTime($researchTime);
            } else {
                /** @var \App\Models\DailyTime */
                $dailyTime = $user->currentDailyTime;
                $this->dailyTimeRepository->updateResearchTime($dailyTime, $researchTime);
            }
            return true;
        });
    }
}
