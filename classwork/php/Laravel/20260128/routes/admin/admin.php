<?php
// routes/admin/admin.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ManagerController;
use App\Http\Controllers\Admin\News\NewsTypeController;
use App\Http\Controllers\Admin\News\AdminNewsController;

Route::prefix('admin')->group(function () {

    // ==============
    // 登入相關（不需要 manager middleware）
    // ==============
    Route::get('/login', [ManagerController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [ManagerController::class, 'doLogin'])->name('admin.login.post');

    Route::get('/forgot', [ManagerController::class, 'showForgot'])->name('admin.forgot');
    Route::get('/register', [ManagerController::class, 'showRegister'])->name('admin.register');

    // ==============
    // 需要登入保護的後台功能
    // ==============
    Route::middleware(['manager'])->group(function () {

        // ✅ 主後台（唯一）：/admin
        Route::get('/', [ManagerController::class, 'index'])->name('admin.index');

        // ✅ 登出（必須 POST）
        Route::post('/logout', [ManagerController::class, 'logout'])->name('admin.logout');

        // =========================================================
        // 最新消息：管理類別（NewsType CRUD）
        // URL 統一用 /admin/news/types/...
        // =========================================================
        Route::get('/news/types', [NewsTypeController::class, 'index'])
            ->name('admin.news.types.index'); // 列表 + 搜尋

        Route::get('/news/types/create', [NewsTypeController::class, 'create'])
            ->name('admin.news.types.create'); // 新增頁

        Route::post('/news/types', [NewsTypeController::class, 'store'])
            ->name('admin.news.types.store'); // 新增送出

        Route::get('/news/types/{id}/edit', [NewsTypeController::class, 'edit'])
            ->whereNumber('id')
            ->name('admin.news.types.edit'); // 編輯頁

        // ✅ 初學者友善：用 POST 做更新，避免 PUT/PATCH method 405
        Route::post('/news/types/{id}/update', [NewsTypeController::class, 'update'])
            ->whereNumber('id')
            ->name('admin.news.types.update');

        // ✅ 初學者友善：用 POST 做刪除
        Route::post('/news/types/{id}/delete', [NewsTypeController::class, 'destroy'])
            ->whereNumber('id')
            ->name('admin.news.types.delete');


        // ==============
        // 最新消息：文章管理（你原本那段保留）
        // ==============
        Route::prefix('news')->name('admin.news.')->middleware(['manager'])->group(function () {
            Route::get('/', [AdminNewsController::class, 'index'])->name('index');          // 列表
            Route::get('/create', [AdminNewsController::class, 'create'])->name('create'); // 新增頁
            Route::post('/', [AdminNewsController::class, 'store'])->name('store');        // 新增送出
            Route::post('/{id}/delete', [AdminNewsController::class, 'destroy'])->name('delete'); // 刪除(用POST避免method問題)
        });

        // ==============
        // 其它功能：施工中
        // ==============
        Route::get('/about', function () {
            return view('admin.coming-soon', [
                'title' => '關於我們',
                'desc'  => '後續可拆成：公司簡介 / 里程碑 / 圖文區塊管理。',
            ]);
        })->name('admin.about');

        Route::get('/products', function () {
            return view('admin.coming-soon', [
                'title' => '產品介紹',
                'desc'  => '後續可拆成：分類 / 產品 / 圖片管理。',
            ]);
        })->name('admin.products');
    });
});
