<?php

namespace App\Console\Commands;

use App\Models\TargetTime;
use App\Models\User;
use App\Models\WeeklyTime;
use Illuminate\Console\Command;
use App\Services\SlackNotificationServiceInterface;
use Illuminate\Support\Facades\Log;

class WeeklyTimeNotificationBatch extends Command
{
    /**
     * @var SlackNotificationServiceInterface
     */
    private $slack_notification_service_interface;

    /**
     * @param SlackNotificationServiceInterface $slack_notification_service_interface
     */
    public function __construct(
        SlackNotificationServiceInterface $slack_notification_service_interface,
    ) {
        parent::__construct();
        $this->slack_notification_service_interface =  $slack_notification_service_interface;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:weekly-time-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '週間研究時間と週間目標時間との差分をSlackで送信';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Slackユーザー一覧を取得してメンションをつけられるように→ユーザー名とSlack名の照合
        $users = User::all();
        foreach ($users as $user) {
            $weeklyTime = WeeklyTime::where('user_id', $user->id)->first();
            $targetTime = TargetTime::where('user_id', $user->id)->first();

            // メッセージ内容を研究状況で分岐
            if ($weeklyTime === null && $targetTime === null) {
                // 今週研究していない、かつ週間目標時間も設定されていない
                $message = "今週はまだ研究をしていません。\n目標時間を設定してください \n\n貴様アアア!逃げるなアア!\n研究から逃げるなアア!";
            } else if ($weeklyTime == null && $targetTime != null) {
                // 今週研究していない場合で週間目標時間は設定されている
                $message = "今週はまだ研究をしていません。" . "\n目標まではあと" . (string)$targetTime->time . "時間です";
            } else if ($weeklyTime != null && $targetTime == null) {
                $message = "あなたの今週の研究時間は" . (string)($weeklyTime->research_time - $weeklyTime->rest_time) . "時間です" . "\n目標を設定してください";
            } else {
                $message = "あなたの今週の研究時間は" . (string)($weeklyTime->research_time - $weeklyTime->rest_time) . "時間です" . "\n目標まではあと" . (string)($targetTime->time - ($weeklyTime->research_time - $weeklyTime->rest_time)) . '時間です';
            }
            $this->slack_notification_service_interface->send($message);
        }
    }
}
