<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Captcha Refresh（換一張）
|--------------------------------------------------------------------------
*/

Route::get('/captcha-refresh', function () {
    return response()->json([
        'captcha' => captcha_img('default'),
    ]);
})->name('captcha.refresh');
