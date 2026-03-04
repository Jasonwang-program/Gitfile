<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\News\NewsTypeController;
use App\Http\Controllers\Admin\News\AdminNewsController;

Route::group(['middleware' => 'manager', 'prefix' => 'admin/news/type'], function () {
    Route::get('list', [NewsTypeController::class, 'list']);
    Route::get('add', [NewsTypeController::class, 'add']);
    Route::post('add', [NewsTypeController::class, 'store']);
});

Route::group(['middleware' => 'manager', 'prefix' => 'admin/news'], function () {
    Route::get('list', [AdminNewsController::class, 'list']);
    Route::get('add', [AdminNewsController::class, 'add']);
    Route::post('add', [AdminNewsController::class, 'insert']);

    Route::get('edit/{id}', [AdminNewsController::class, 'edit']);
    Route::post('edit', [AdminNewsController::class, 'update']);

    Route::post('delete', [AdminNewsController::class, 'delete']);

    Route::get('export', [AdminNewsController::class, 'export']);
});
