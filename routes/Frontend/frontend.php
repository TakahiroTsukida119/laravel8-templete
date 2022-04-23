<?php

use Illuminate\Support\Facades\Route;

/**
 * フロントエンドダミールート
 */
Route::domain(config('app.domain'))->group(function () {
    Route::get('/', fn() => abort(404))->name('frontend.top');
});
