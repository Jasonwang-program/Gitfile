<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\News\NewsTypeController;

Route::group(['middleware' => 'manager', 'prefix' => 'admin/news/type'], function () {

    // 類別列表
    Route::get('list', [NewsTypeController::class, 'list']);

    // 顯示新增頁
    Route::get('add', [NewsTypeController::class, 'add']);

    // 新增送出（寫入DB）
    Route::post('add', [NewsTypeController::class, 'store']);
});
