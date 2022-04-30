<?php

use Illuminate\Support\Facades\Route;

/**
 * バックエンド用ダミールート
 */
Route::domain('admin.' . config('app.domain'))->group(function () {
    Route::get('/', fn() => abort(404))->name('nuxt.backend.top');
    Route::get('/reset', fn () => abort(404))->name('nuxt.backend.reset');
});
