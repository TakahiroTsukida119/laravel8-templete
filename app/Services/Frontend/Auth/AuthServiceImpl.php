<?php
declare(strict_types=1);

namespace App\Services\Frontend\Auth;

use App\Exceptions\InProgressApplyException;
use App\Models\User;
use App\Repositories\WaitingList\Params\ApplyCancelParams;
use Carbon\CarbonImmutable;
use Exception;
use Illuminate\Auth\AuthenticationException;
use PHPOpenSourceSaver\JWTAuth\Contracts\Providers\JWT;

/**
 * Class AuthServiceImpl
 * @package App\Services\Frontend\Auth
 */
class AuthServiceImpl implements AuthService
{
    /**
     * @inheritDoc
     */
    public function getAuthUser(): User
    {
        $userOrNull = $this->getAuthUserOrNull();
        if (!isset($userOrNull)) {
            throw new AuthenticationException(__('exception.'));
        }
        return $userOrNull;
    }

    /**
     * @inheritDoc
     */
    public function getAuthUserOrNull(): ?User
    {
        /**
         * @var User|null $userOrNull
         */
        $userOrNull = auth('api')->user();
        return $userOrNull;
    }

    /**
     * @inheritDoc
     */
    public function logout(): void
    {
        auth('api')->logout();
    }

    /**
     * @inheritDoc
     */
    public function refresh(): string
    {
        return auth('api')->refresh();
    }

    /**
     * @inheritdoc
     */
    public function invalidate(): JWT
    {
        return auth('api')->invalidate();
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
