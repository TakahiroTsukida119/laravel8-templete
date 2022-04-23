<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Class LoginController
 * @package App\Http\Controllers\Backend\Auth
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * ログインフォーム
     *
     * @return View
     */
    public function showLoginForm(): View
    {
        return view('backend.auth.login');
    }

    /**
     * ログイン
     *
     * @param Request $request
     * @return JsonResponse|Response|RedirectResponse
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse|Response|RedirectResponse
    {
        $validator = Validator::make($request->only(['email', 'password']), [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            $this->loginFailed();
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }

        $isValid = Auth::guard('admin')->attempt(
            $request->only(['email', 'password']),
            $request->filled('remember')
        );

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if (!$isValid) {
            $this->incrementLoginAttempts($request);
            $this->loginFailed();
        }

        return redirect()
            ->route('backend.home')
            ->with('alert_success', __('message.success.login'));
    }

    /**
     * ログアウト
     *
     * @param Request $request
     * @return Response|Redirector|Application|RedirectResponse|ResponseFactory
     */
    public function logout(Request $request): Response|Redirector|RedirectResponse|Application|ResponseFactory
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $request->wantsJson()
            ? response('', 204)
            : redirect(route('backend.login'));
    }

    /**
     * ログイン失敗の例外をスローします
     * @throws ValidationException
     */
    private function loginFailed(): void
    {
        throw ValidationException::withMessages([
            'password' => __('validation.login_password')
        ]);
    }
}
