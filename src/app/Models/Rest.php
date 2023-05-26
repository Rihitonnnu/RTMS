<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;

class Rest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'research_id',
        'start_time',
        'end_time',
    ];

    public function research()
    {
        return $this->belongsTo(Time::class);
    }

    /**
     * 開始時間を登録する
     *
     * @param integer $researchId
     * @return boolean
     */
    public function storeTime(int $researchId)
    {
        try {
            DB::beginTransaction();
            $rest = $this->create([
                'research_id' => $researchId,
                'start_time' => Carbon::now()
            ]);
            $research = Research::find($researchId);

            if ($research->user->is_rested) { // 開始時間が打刻されている場合はrollbackしてエラーメッセージを表示させる
                DB::rollBack();
                return false;
            }
            $research->user->fill(['is_rested' => true, 'rest_id' => $rest->id])->save();
            DB::commit();
            return true;
        } catch (Throwable $e) {
            Log::debug($e);
            DB::rollBack();
        }
    }

    /**
     * 終了時間を登録する
     *
     * @param integer $researchId
     * @return boolean
     */
    public function updateTime(int $researchId)
    {
        $research = Research::find($researchId);
        if (!$research->user->is_rested) {
            return false;
        }
        // ここもトランザクション加えたほうがいいかも
        $research->user->currentRest->fill(['end_time' => Carbon::now()])->save();
        return $research->user->fill(['is_rested' => false])->save();
    }
}
