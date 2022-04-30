<?php

use App\Http\Controllers\Backend\Auth\ForgotPasswordController;
use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\Auth\LogoutController;
use App\Http\Controllers\Backend\Auth\RefreshController;
use App\Http\Controllers\Backend\Auth\ResetPasswordController;
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
    Route::prefix('/v1/admins/')->group(function () {
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
            Route::post('/login', [LoginController::class, 'login'])->name('admin.auth.login');

            Route::middleware('throttle:30,1')->group(function () {
                // アクセストークンのリフレッシュ
                Route::post('/refresh', [RefreshController::class, 'refresh'])->name('admin.auth.refresh');
                //パスワードリセット
                Route::post('/forgot', [ForgotPasswordController::class, 'forgot'])->name('admin.auth.forgot');
                Route::post('/reset', [ResetPasswordController::class, 'reset'])->name('admin.auth.reset');
            });

            Route::middleware('auth:admin')->group(function () {
                // ログアウト
                Route::post('/logout', [LogoutController::class, 'logout'])->name('admin.auth.logout');

            });
        });

        // ログイン後
        Route::middleware('auth:admin')->group(function () {

        });
    });

    Route::any('/{any}', fn() => abort(404));
});
