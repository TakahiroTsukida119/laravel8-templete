<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use App\Repositories\Admin\AdminAuthRepositoryContract;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use JetBrains\PhpStorm\ArrayShape;

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
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param Request $request
     * @param string|null $token
     * @return View
     */
    public function showResetForm(Request $request, ?string $token = null): View
    {
        return view('backend.auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape(['token' => "string", 'email' => "string", 'password' => "string[]"])]
    protected function rules(): array
    {
        return [
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => ['required', 'confirmed', 'min:8', 'max:32'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function broker(): PasswordBroker
    {
        return Password::broker('admins');
    }

    /**
     * @inheritDoc
     */
    protected function guard(): Guard|StatefulGuard
    {
        return Auth::guard('admin');
    }

    /**
     * @inheritDoc
     */
    public function redirectPath(): string
    {
        return route('backend.home');
    }

    /**
     * @inheritDoc
     */
    protected function sendResetResponse(
        Request $request,
        $response
    ): JsonResponse|Redirector|RedirectResponse|Application
    {
        if ($request->wantsJson()) {
            return new JsonResponse(['message' => trans($response)], 200);
        }

        return redirect($this->redirectPath())
            ->with('alert_success', trans($response));
    }

    /**
     * @inheritDoc
     */
    public function reset(
        Request $request,
        AdminAuthRepositoryContract $adminAuth
    ): JsonResponse|Redirector|RedirectResponse|Application
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset($this->credentials($request), function (Admin $admin, $password) {
            $this->resetPassword($admin, $password);
        });

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response === Password::PASSWORD_RESET
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse($request, $response);
    }
}
