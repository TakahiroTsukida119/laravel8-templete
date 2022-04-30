<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backend\Auth;

use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\AdminResetRequest;
use App\Http\Requests\Frontend\Auth\ResetRequest;
use App\Models\Admin;
use App\OpenApi\RequestBodies\Backend\Auth\AdminResetPasswordRequestBody;
use App\OpenApi\Responses\Backend\Auth\LoginAdminResponse;
use App\OpenApi\Responses\Exceptions\BadRequestResponse;
use App\OpenApi\Responses\Exceptions\TooManyRequestsResponse;
use App\OpenApi\Responses\Exceptions\ValidationErrorResponse;
use App\OpenApi\Responses\Frontend\Auth\LoginUserResponse;
use App\Providers\RouteServiceProvider;
use App\Services\Backend\Auth\AdminAuthService;
use App\ViewModels\Backend\Auth\AdminLoginViewModel;
use App\ViewModels\Frontend\Auth\AccessTokenViewModel;
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
 * @package App\Http\Controllers\Backend\Auth
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
     * @param AdminResetRequest $request
     * @param AdminAuthService $authService
     * @return JsonResponse
     * @throws BadRequestException
     */
    #[OpenApi\Operation('AdminResetPassword', ['admin_auth'], null, 'POST')]
    #[OpenApi\RequestBody(AdminResetPasswordRequestBody::class)]
    #[OpenApi\Response(LoginAdminResponse::class, 200)]
    #[OpenApi\Response(BadRequestResponse::class, 400)]
    #[OpenApi\Response(ValidationErrorResponse::class, 422)]
    #[OpenApi\Response(TooManyRequestsResponse::class, 429)]
    public function reset(AdminResetRequest $request, AdminAuthService $authService): JsonResponse
    {

        $broker = Password::broker('admins');

        $response = $broker->reset($request->getCredential(), function (Admin $admin) use ($request) {
            $this->token = $this->resetPassword($admin, $request->getPassword());
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
            ->json(new AdminLoginViewModel((string)$this->token));
    }

    /**
     * @inheritDoc
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * @param Admin $admin
     * @param string $password
     * @return string
     */
    protected function resetPassword(Admin $admin, string $password)
    {
        $this->setUserPassword($admin, $password);

        $admin->setRememberToken(Str::random(60));

        $admin->save();

        event(new PasswordReset($admin));

        return $this->guard()->login($admin);
    }
}
