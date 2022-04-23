<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Services\Frontend\Auth\AuthService;
use App\ViewModels\Frontend\Auth\AccessTokenViewModel;
use Illuminate\Http\JsonResponse;

/**
 * Class RefreshController
 * @package App\Http\Controllers\Frontend\Auth
 */
class RefreshController extends Controller
{
    /**
     * アクセストークンの再発行処理
     *
     * @param AuthService $auth
     * @return JsonResponse
     */
    public function refresh(AuthService $auth): JsonResponse
    {
        $token = $auth->refresh();
        return response()
            ->json((new AccessTokenViewModel($token)));
    }
}
