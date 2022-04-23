<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Exceptions\BadRequestException;
use App\Exceptions\TooManyRequestsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\ForgotRequest;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

/**
 * Class ForgotPasswordController
 * @package App\Http\Controllers\Frontend\Auth
 */
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    /**
     * パスワードリセットメールの送信
     *
     * @param ForgotRequest $request
     * @return JsonResponse
     * @throws BadRequestException
     * @throws TooManyRequestsException
     */
    public function forgot(ForgotRequest $request): JsonResponse
    {

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $broker = Password::broker('users');
        $response = $broker->sendResetLink(['email' => $request->getEmail()]);

        if ($response === Password::INVALID_USER) {
            throw new BadRequestException(
                BadRequestException::CODE_INVALID_EMAIL,
                __('exception.invalid_email')
            );
        }

        if ($response === Password::RESET_THROTTLED) {
            throw new TooManyRequestsException(
                config('auth.passwords.users.throttle') / 60,
                config('auth.passwords.users.throttle'),
                __('passwords.throttled')
            );
        }

        return response()->json();
    }
}
