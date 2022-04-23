<?php

use App\Http\Controllers\Frontend\Auth\ForgotPasswordController;
use App\Http\Controllers\Frontend\Auth\LoginController;
use App\Http\Controllers\Frontend\Auth\LogoutController;
use App\Http\Controllers\Frontend\Auth\RefreshController;
use App\Http\Controllers\Frontend\Auth\ResetPasswordController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::domain('api.' . config('app.domain'))->group(function () {
    Route::prefix('/v1')->group(function () {
        Route::get('/hello', function () {
            return response()->json([
                'message' => "Hello World"
            ]);
        });
        Route::get('/404', function () {
            throw new ModelNotFoundException();
        });

        // 認証系API
        Route::prefix('auth')->group(function () {
            // ログイン
            Route::post('/login', [LoginController::class, 'login'])->name('api.auth.login');

            Route::middleware('throttle:30,1')->group(function () {
                // アクセストークンのリフレッシュ
                Route::post('/refresh', [RefreshController::class, 'refresh'])->name('api.auth.refresh');
                //パスワードリセット
                Route::post('/forgot', [ForgotPasswordController::class, 'forgot'])->name('api.auth.forgot');
                Route::post('/reset', [ResetPasswordController::class, 'reset'])->name('api.auth.reset');
            });

            Route::middleware('auth:api')->group(function () {
                // ログアウト
                Route::post('/logout', [LogoutController::class, 'logout'])->name('api.auth.logout');

            });
        });

        // ログイン後
        Route::middleware('auth:api')->group(function () {

        });
    });
});
