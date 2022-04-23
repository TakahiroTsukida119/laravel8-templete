<?php
declare(strict_types=1);

namespace App\Services\Frontend\Auth;

use App\Models\User;
use Exception;
use Illuminate\Auth\AuthenticationException;
use PHPOpenSourceSaver\JWTAuth\Contracts\Providers\JWT;


/**
 * Interface AuthService
 * @package App\Services\Frontend\Auth
 */
interface AuthService
{
    /**
     * 認証されているユーザー情報を取得します。認証状態でない場合はAuthenticateExceptionをthrowします
     * @return User
     * @throws AuthenticationException
     */
    public function getAuthUser(): User;

    /**
     * 認証されているユーザー情報を取得します。認証状態でない場合はnullを返します
     * @return User|null
     */
    public function getAuthUserOrNull(): User|null;

    /**
     * 認証ユーザーのログアウトを行います
     */
    public function logout(): void;

    /**
     * アクセストークンの再発行を行います
     * @return string 再発行されたアクセストークン
     */
    public function refresh(): string;

    /**
     * アクセストークン無効化を行います
     * @return JWT
     */
    public function invalidate(): JWT;

    /**
     * 退会
     * @throws AuthenticationException|Exception
     */
    public function leave(): void;
}
