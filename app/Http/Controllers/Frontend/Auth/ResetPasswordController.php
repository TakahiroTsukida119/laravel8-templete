<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\ResetRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\ViewModels\Frontend\Auth\AccessTokenViewModel;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Class ResetPasswordController
 * @package App\Http\Controllers\Frontend\Auth
 */
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
     * @param ResetRequest $request
     * @return JsonResponse
     * @throws BadRequestException
     */
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
            ->json(new AccessTokenViewModel($this->token));
    }

    /**
     * @inheritDoc
     */
    protected function guard()
    {
        return Auth::guard('api');
    }

    /**
     * @param User $user
     * @param string $password
     * @return string
     */
    protected function resetPassword(User $user, string $password): string
    {
        $this->setUserPassword($user, $password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        return $this->guard()->login($user);
    }
}
