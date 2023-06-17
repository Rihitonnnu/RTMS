<?php

namespace App\Repositories\DailyTime;

use App\Models\DailyTime;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DailyTimeRepository implements DailyTimeRepositoryInterface
{
    private $dailyTime;
    /**
     * @param \App\Models\DailyTime $dailyTime
     * @return void
     */
    public function __construct(DailyTime $dailyTime)
    {
        $this->dailyTime = $dailyTime;
    }

    /**
     * 今日の研究時間を登録する
     *
     * @param float $researchTime
     * @return bool
     */
    public function storeResearchTime(float $researchTime): bool
    {
        $userId = Auth::id();
        $createdDailyTime = $this->dailyTime->create([
            'date' => Carbon::now(),
            'user_id' => $userId,
            'research_time' => $researchTime,
        ]);
        return User::find($userId)->fill(['daily_time_id' => $createdDailyTime->id])->save();
    }

    /**
     * 今日の研究時間を加算して更新する
     * 
     * @param \App\Models\DailyTime $dailyTime
     * @param float $researchTime
     * @return bool
     */
    public function updateResearchTime(DailyTime $dailyTime, float $researchTime): bool
    {
        $updatedDailyTime = $dailyTime->research_time + $researchTime;
        return $dailyTime->fill(['research_time' => $updatedDailyTime])->save();
    }

    /**
     * 今日の休憩時間を登録する
     *
     * @param float $restTime
     * @return bool
     */
    public function storeRestTime(float $restTime): bool
    {
        $userId = Auth::id();
        $createdDailyTime = $this->dailyTime->create([
            'date' => Carbon::now(),
            'user_id' => $userId,
            'rest_time' => $restTime,
        ]);
        return User::find($userId)->fill(['daily_time_id' => $createdDailyTime->id])->save();
    }

    /**
     * 今日の休憩時間を加算して更新する
     * 
     * @param \App\Models\DailyTime $dailyTime
     * @param float $restTime
     * @return bool
     */
    public function updateRestTime(DailyTime $dailyTime, float $restTime): bool
    {
        $updatedDailyTime = $dailyTime->research_time + $restTime;
        return $dailyTime->fill(['rest_time' => $updatedDailyTime])->save();
    }

    /**
     * 任意の日にちの研究・休憩時間を更新
     *
     * @param float $researchTime
     * @param float $restTime
     * @param DailyTime $dailyTime
     * @return bool
     */
    public function updateDailyTime(float $researchTime, float $restTime, DailyTime $dailyTime): bool
    {
        return $dailyTime->fill(['research_time' => $researchTime, 'rest_time' => $restTime])->save();
    }

    /**
     * 任意の日にちの研究・休憩時間を削除(実際に削除するわけではない)
     *
     * @param DailyTime $dailyTime
     * @return bool
     */
    public function destroyDailyTime(DailyTime $dailyTime): bool
    {
        return $dailyTime->delete();
    }

    /**
     * 研究時間を登録していない日にからのデータを登録
     *
     * @param \Carbon\Carbon $firstDayThisMonth
     * @param \Carbon\Carbon $now
     * @return void
     */
    public function storeNotRegisteredDay($firstDayThisMonth, $now)
    {
        // 今日までの表示でいいかも
        $date = $firstDayThisMonth;
        $userId = Auth::id();
        while ($date->lt($now)) {
            // Larastanのエラー解決法がわからないので一旦保留
            if (DailyTime::where('date', '=', Carbon::parse($date)->format('Y-m-d'))->get()->isEmpty()) {/* @phpstan-ignore-line */
                $this->dailyTime->create([
                    'user_id' => $userId,
                    'date' => $date,
                    'research_time' => null,
                    'rest_time' => null,
                ]);
            }
            $date = $date->addDay();
        }
    }
}
