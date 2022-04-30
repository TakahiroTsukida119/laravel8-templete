<?php
declare(strict_types=1);

namespace App\Services\Backend\Auth;

use App\Exceptions\InProgressApplyException;
use App\Models\Admin;
use App\Models\User;
use App\Repositories\WaitingList\Params\ApplyCancelParams;
use Carbon\CarbonImmutable;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Contracts\Providers\JWT;
use PHPOpenSourceSaver\JWTAuth\JWTGuard;

/**
 * Class AdminAuthServiceImpl
 * @package App\Services\Backend\Auth
 */
class AdminAuthServiceImpl implements AdminAuthService
{
    private Guard|JWTGuard $auth;

    /**
     * AdminAuthServiceImpl constructor.
     */
    public function __construct()
    {
        $this->auth = Auth::guard('admin');
    }

    /**
     * @inheritDoc
     */
    public function getAuthUser(): Admin
    {
        $userOrNull = $this->getAuthUserOrNull();
        if (!isset($userOrNull)) {
            throw new AuthenticationException(__('exception.unauthenticated'));
        }
        return $userOrNull;
    }

    /**
     * @inheritDoc
     */
    public function getAuthUserOrNull(): ?Admin
    {
        /**
         * @var Admin|null $userOrNull
         */
        $userOrNull = $this->auth->user();
        return $userOrNull;
    }

    /**
     * @inheritDoc
     */
    public function logout(): void
    {
        $this->auth->logout();
    }

    /**
     * @inheritDoc
     */
    public function refresh(): string
    {
        return $this->auth->refresh();
    }

    /**
     * @inheritdoc
     */
    public function invalidate(): JWT
    {
        return $this->auth->invalidate();
    }

    /**
     * @inheritdoc
     */
    public function leave(): void
    {
        $user = $this->getAuthUser();
        $this->logout();
        $user->delete();
        $this->invalidate();
    }
}
