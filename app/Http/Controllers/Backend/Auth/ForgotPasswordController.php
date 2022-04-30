<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backend\Auth;

use App\Exceptions\BadRequestException;
use App\Exceptions\TooManyRequestsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\AdminForgotRequest;
use App\OpenApi\RequestBodies\Backend\Auth\AdminForgotPasswordRequestBody;
use App\OpenApi\Responses\Exceptions\BadRequestResponse;
use App\OpenApi\Responses\Exceptions\TooManyRequestsResponse;
use App\OpenApi\Responses\Exceptions\ValidationErrorResponse;
use App\OpenApi\Responses\DefaultPostSuccessResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

/**
 * Class ForgotPasswordController
 * @package App\Http\Controllers\Backend\Auth
 */
#[OpenApi\PathItem]
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
     * パスワード再設定のメールを送信します。
     * 送信メールのURLのクエリパラメーターとして`email`と`token`を付与します。
     * パスワードリセットのときはこの`email`と`token`を利用してください。
     *
     * @param AdminForgotRequest $request
     * @return JsonResponse
     * @throws BadRequestException
     * @throws TooManyRequestsException
     */
    #[OpenApi\Operation('AdminForgotPassword', ['admin_auth'], null, 'POST')]
    #[OpenApi\RequestBody(AdminForgotPasswordRequestBody::class)]
    #[OpenApi\Response(DefaultPostSuccessResponse::class, 200)]
    #[OpenApi\Response(BadRequestResponse::class, 400)]
    #[OpenApi\Response(ValidationErrorResponse::class, 422)]
    #[OpenApi\Response(TooManyRequestsResponse::class, 429)]
    public function forgot(AdminForgotRequest $request): JsonResponse
    {

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $broker = Password::broker('admins');
        $response = $broker->sendResetLink(['email' => $request->getEmail()]);

        if ($response === Password::INVALID_USER) {
            throw new BadRequestException(
                BadRequestException::CODE_INVALID_EMAIL,
                __('exception.invalid_email')
            );
        }

        if ($response === Password::RESET_THROTTLED) {
            throw new TooManyRequestsException(
                config('auth.passwords.admins.throttle') / 60,
                config('auth.passwords.admins.throttle'),
                __('passwords.throttled')
            );
        }

        return response()->json();
    }
}
