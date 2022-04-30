<?php

namespace App\Modules\Notifiable;

use App\Jobs\SendMailJob;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

/**
 * JobNotifiable 非同期でメールを送信するNotifiable
 * @package App\Modules\Notifiable
 */
trait JobNotifiable
{
    use Notifiable;

    /**
     * 非同期でメールを送信します。（キューイング）
     * @param Notification $notification 送信内容
     * @param BaseNotifiableParams $params 送信パラメーター
     * @return PendingDispatch
     */
    public function notifyAsync(Notification $notification, BaseNotifiableParams $params): PendingDispatch
    {
        return SendMailJob::dispatch($this, $notification, $params);
    }
}
