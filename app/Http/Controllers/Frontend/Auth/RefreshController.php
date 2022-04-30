<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\OpenApi\Responses\Exceptions\TooManyRequestsResponse;
use App\OpenApi\Responses\Exceptions\UnauthorizedResponse;
use App\OpenApi\Responses\Frontend\Auth\LoginUserResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use App\Services\Frontend\Auth\UserAuthService;
use App\ViewModels\Frontend\Auth\AccessTokenViewModel;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

/**
 * Class RefreshController
 * @package App\Http\Controllers\Frontend\Auth
 */
#[OpenApi\PathItem]
class RefreshController extends Controller
{
    /**
     * アクセストークンの再発行
     *
     * アクセストークンの有効期限が切れた場合はこちらでアクセストークンの再発行を行ってください
     *
     * @param UserAuthService $auth
     * @return JsonResponse
     * @throws AuthenticationException
     */
    #[OpenApi\Operation('RefreshUserAccessToken', ['user_auth'], BearerTokenSecurityScheme::class, 'POST')]
    #[OpenApi\Response(LoginUserResponse::class, 200)]
    #[OpenApi\Response(UnauthorizedResponse::class, 401)]
    public function refresh(UserAuthService $auth): JsonResponse
    {
        try {
            $token = $auth->refresh();
        } catch (Exception $e) {
            throw new AuthenticationException(trans('exception.invalid_token'));
        }
        return response()
            ->json((new AccessTokenViewModel($token)));
    }
}
