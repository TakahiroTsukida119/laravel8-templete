<?php
declare(strict_types=1);

namespace App\Jobs;

use App\Modules\Notifiable\BaseNotifiableParams;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Redis\LimiterTimeoutException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use RuntimeException;

/**
 * Class SendMailJob メール送信
 * @package App\Jobs
 */
class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public const SEND_MAIL_RATE_LIMIT_REDIS_KEY = 'send_mail_limit_locks';

    /**
     * @var Notifiable
     */
    private $notifiable;
    private Notification $notification;
    private BaseNotifiableParams $params;


    /**
     * SendMailJob constructor.
     * @param  mixed $notifiable  送信対象
     * @param  Notification  $notification  送信内容
     * @param BaseNotifiableParams $params 送信パラメータークラス
     */
    public function __construct(
        $notifiable,
        Notification $notification,
        BaseNotifiableParams $params
    ) {
        $this->notifiable = $notifiable;
        $this->notification = $notification;
        $this->params = $params;
    }

    /**
     * メールを送信します（秒間14通の制限）
     * @return void
     * @throws LimiterTimeoutException
     */
    public function handle(): void
    {
        try {
            Log::info($this->params->getStartMessage(), $this->params->toArray());
            Redis::throttle(self::SEND_MAIL_RATE_LIMIT_REDIS_KEY)
                ->allow(14)
                ->every(1)
                ->then(function () {
                    $this->notifiable->notify($this->notification);
                }, function () {
                    $this->release(1);
                });
            Log::info($this->params->getSuccessMessage(), $this->params->toArray());
        } catch (RuntimeException $e) {
            Log::error($this->params->getErrorMessage(), $this->params->toArray());
            throw $e;
        }
    }
}
