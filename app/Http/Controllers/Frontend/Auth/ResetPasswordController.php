<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\ResetRequest;
use App\Models\User;
use App\OpenApi\RequestBodies\Frontend\Auth\ResetPasswordRequestBody;
use App\OpenApi\Responses\Exceptions\BadRequestResponse;
use App\OpenApi\Responses\Exceptions\TooManyRequestsResponse;
use App\OpenApi\Responses\Exceptions\ValidationErrorResponse;
use App\OpenApi\Responses\Frontend\Auth\LoginUserResponse;
use App\Providers\RouteServiceProvider;
use App\Services\Frontend\Auth\UserAuthService;
use App\ViewModels\Frontend\Auth\AccessTokenViewModel;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

/**
 * Class ResetPasswordController
 * @package App\Http\Controllers\Frontend\Auth
 */
#[OpenApi\PathItem]
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    private ?string $token = null;

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param Request $request
     * @param string|null $token
     * @return View
     */
    public function showResetForm(Request $request, string|null $token = null): View
    {
        return view('frontend.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * パスワードリセット
     *
     * ユーザーのパスワードを再設定します。
     * パスワードリセットメールに添付のURLのクエリパラメーター`email`と`token`を使用してください。
     *
     * @param ResetRequest $request
     * @return JsonResponse
     * @throws BadRequestException
     */
    #[OpenApi\Operation('ResetPassword', ['user_auth'], null, 'POST')]
    #[OpenApi\RequestBody(ResetPasswordRequestBody::class)]
    #[OpenApi\Response(LoginUserResponse::class, 200)]
    #[OpenApi\Response(BadRequestResponse::class, 400)]
    #[OpenApi\Response(ValidationErrorResponse::class, 422)]
    #[OpenApi\Response(TooManyRequestsResponse::class, 429)]
    public function reset(ResetRequest $request): JsonResponse
    {

        $broker = Password::broker('users');

        $response = $broker->reset($request->getCredential(), function (User $user) use ($request) {
            $this->token = $this->resetPassword($user, $request->getPassword());
        });

        if ($response === Password::INVALID_USER) {
            throw new BadRequestException(
                BadRequestException::CODE_INVALID_EMAIL,
                __('exception.invalid_email')
            );
        }

        if ($response === Password::INVALID_TOKEN) {
            throw new BadRequestException(
                BadRequestException::CODE_INVALID_TOKEN,
                __('exception.invalid_token')
            );
        }
        return response()
            ->json(new AccessTokenViewModel((string)$this->token));
    }

    /**
     * @inheritDoc
     */
    protected function guard()
    {
        return Auth::guard('user');
    }

    /**
     * @param User $user
     * @param string $password
     * @return string
     */
    protected function resetPassword(User $user, string $password)
    {
        $this->setUserPassword($user, $password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        return $this->guard()->login($user);
    }
}
