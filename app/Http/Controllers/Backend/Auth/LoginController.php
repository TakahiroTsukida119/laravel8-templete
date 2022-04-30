<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backend\Auth;

use App\Exceptions\TooManyRequestsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\LoginRequest;
use App\OpenApi\RequestBodies\Backend\Auth\LoginAdminRequestBody;
use App\OpenApi\Responses\Backend\Auth\LoginAdminResponse;
use App\OpenApi\Responses\Exceptions\TooManyRequestsResponse;
use App\OpenApi\Responses\Exceptions\UnauthorizedResponse;
use App\ViewModels\Backend\Auth\AdminLoginViewModel;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

/**
 * Class LoginController
 * @package App\Http\Controllers\Backend\Auth
 */
#[OpenApi\PathItem]
class LoginController extends Controller
{
    use ThrottlesLogins;


    /**
     * ユーザーログイン
     *
     * ユーザーのログインです。
     * アクセストークンの有効期限は60分です。
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthenticationException
     * @throws TooManyRequestsException
     */
    #[OpenApi\Operation('LoginAdmin', ['admin_auth'], null, 'POST')]
    #[OpenApi\RequestBody(LoginAdminRequestBody::class)]
    #[OpenApi\Response(LoginAdminResponse::class, 200)]
    #[OpenApi\Response(UnauthorizedResponse::class, 401)]
    #[OpenApi\Response(TooManyRequestsResponse::class, 429)]
    public function login(Request $request): JsonResponse
    {
        /** @var LoginRequest $request */
        $request = LoginRequest::createFrom($request);

        if (!$request->isValid()) {
            throw new AuthenticationException(__('exception.login_failed'));
        }

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }

        $token = Auth::guard('admin')->attempt($request->only(['email', 'password']));
        event(new Login('admin', auth('admin')->user(), true));
        if (empty($token)) {
            $this->incrementLoginAttempts($request);
            throw new AuthenticationException(__('exception.login_failed'));
        }
        return response()
            ->json(new AdminLoginViewModel((string)$token));
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param Request $request
     * @return void
     * @throws TooManyRequestsException
     */
    protected function sendLockoutResponse(Request $request): void
    {
        $seconds = $this->limiter()->availableIn($this->throttleKey($request));

        throw new TooManyRequestsException(
            (int)ceil($seconds / 60),
            $seconds,
            __('auth.throttle'),
        );
    }

    /**
     * @inheritDoc
     */
    protected function throttleKey(Request $request): string
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }

    /**
     * @return int
     */
    public function decayMinutes(): int
    {
        return config('auth.login_decay_minutes');
    }
}
