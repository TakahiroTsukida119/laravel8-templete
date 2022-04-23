<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Exceptions\TooManyRequestsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\LoginRequest;
use App\ViewModels\Frontend\Auth\AccessTokenViewModel;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class LoginController
 * @package App\Http\Controllers\Frontend\Auth
 */
class LoginController extends Controller
{
    use ThrottlesLogins;


    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthenticationException
     * @throws TooManyRequestsException
     */
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

        $token = Auth::guard('api')->attempt($request->only(['email', 'password']));
        event(new Login('api', auth('api')->user(), true));
        if (empty($token)) {
            $this->incrementLoginAttempts($request);
            throw new AuthenticationException(__('exception.login_failed'));
        }
        return response()
            ->json(new AccessTokenViewModel($token));
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
