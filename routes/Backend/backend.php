<?php

use App\Http\Controllers\Backend\Auth\ForgotPasswordController;
use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::domain('admin.' . config('app.domain'))->group(function () {
    // ダミー
    Route::get('/', fn() => view('backend.sample'));

    Route::middleware('guest:admin')->group(function () {
        // ログイン
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('backend.login');
        Route::post('/login', [LoginController::class, 'login'])->name('backend.login');

        // パスワードリセット
        Route::get('/password/forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('backend.password.forgot');
        Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('backend.password.email');
        Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('backend.password.reset');
        Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('backend.password.update');
    });

    // ログイン後
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('backend.logout');
    });

    Route::any('/{any}', fn() => abort(404));
});
