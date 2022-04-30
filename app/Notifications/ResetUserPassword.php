<?php
declare(strict_types=1);

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

/**
 * Class ResetUserPassword
 * @package App\Notifications
 */
class ResetUserPassword extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * The callback that should be used to create the reset password URL.
     *
     * @var \Closure|null
     */
    public static $createUrlCallback;

    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;

    /**
     * Create a notification instance.
     *
     * @param string $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param mixed $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param User $notifiable
     * @return MailMessage
     */
    public function toMail(User $notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        if (static::$createUrlCallback) {
            $url = call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        } else {
            $url = config('app.url') . route('nuxt.frontend.reset', [
                    'token' => $this->token,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ], false);
        }

        return (new MailMessage)
            ->markdown('notifications.email')
            ->subject(__('notification.reset_user_password.subject'))
            ->greeting('')
            ->line(new HtmlString(__('notification.reset_user_password.request')))
            ->action(__('notification.reset_user_password.link'), $url)
            ->line(__('notification.reset_user_password.expire', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]))
            ->line(__('notification.reset_user_password.no_further'));
    }

    /**
     * Set a callback that should be used when creating the reset password button URL.
     *
     * @param \Closure $callback
     * @return void
     */
    public static function createUrlUsing($callback)
    {
        static::$createUrlCallback = $callback;
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param \Closure $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}
