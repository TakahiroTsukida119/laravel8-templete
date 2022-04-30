<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\OpenApi\Responses\Exceptions\UnauthorizedResponse;
use App\OpenApi\Responses\DefaultPostSuccessResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use App\Services\Frontend\Auth\UserAuthService;
use Illuminate\Http\JsonResponse;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

/**
 * Class LogoutController
 * @package App\Http\Controllers\Frontend\Auth
 */
#[OpenApi\PathItem]
class LogoutController extends Controller
{
    /**
     * ログアウト
     *
     * ユーザーのアクセストークンを失効させます。
     * セキュリティ向上のために必ず利用してください。
     *
     * @param UserAuthService $auth
     * @return JsonResponse
     */
    #[OpenApi\Operation('LogoutUser', ['user_auth'], BearerTokenSecurityScheme::class, 'POST')]
    #[OpenApi\Response(DefaultPostSuccessResponse::class, 200)]
    #[OpenApi\Response(UnauthorizedResponse::class, 401)]
    public function logout(UserAuthService $auth): JsonResponse
    {
        $auth->logout();
        return response()->json();
    }
}
