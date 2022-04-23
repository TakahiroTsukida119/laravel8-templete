<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Services\Frontend\Auth\AuthService;
use Illuminate\Http\JsonResponse;

/**
 * Class LogoutController
 * @package App\Http\Controllers\Frontend\Auth
 */
class LogoutController extends Controller
{
    /**
     * ログアウトAPI
     * @param AuthService $auth
     * @return JsonResponse
     */
    public function logout(AuthService $auth): JsonResponse
    {
        $auth->logout();
        return response()->json();
    }
}
