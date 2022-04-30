<?php
declare(strict_types=1);

namespace App\Services\Backend\Auth;

use App\Models\Admin;
use Exception;
use Illuminate\Auth\AuthenticationException;
use PHPOpenSourceSaver\JWTAuth\Contracts\Providers\JWT;


/**
 * Interface AdminAuthService
 * @package App\Services\Backend\Auth
 */
interface AdminAuthService
{
    /**
     * 認証されているユーザー情報を取得します。認証状態でない場合はAuthenticateExceptionをthrowします
     * @return Admin
     * @throws AuthenticationException
     */
    public function getAuthUser(): Admin;

    /**
     * 認証されているユーザー情報を取得します。認証状態でない場合はnullを返します
     * @return Admin|null
     */
    public function getAuthUserOrNull(): Admin|null;

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
