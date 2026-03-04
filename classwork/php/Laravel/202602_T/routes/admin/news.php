<?php

use App\Http\Controllers\Admin\News\AdminNewsController;
use App\Http\Controllers\Admin\News\NewsTypeController;
use Illuminate\Support\Facades\Route;

/*
Route::group(["middleware" => "manager", "prefix" => "admin/news/type"], function(){
    Route::get("list", [NewsTypeController::class, "list"]);
    Route::get("add", [NewsTypeController::class, "add"]);
    Route::post("add", [NewsTypeController::class, "insert"]);
    Route::get("edit/{id}", [NewsTypeController::class, "edit"]);
    Route::post("edit", [NewsTypeController::class, "update"]);
    Route::post("delete", [NewsTypeController::class, "delete"]);
});
*/

Route::group(["middleware" => "manager", "prefix" => "admin/news"], function () {
    Route::get("list", [AdminNewsController::class, "list"]);
    Route::get("add", [AdminNewsController::class, "add"]);
    Route::post("add", [AdminNewsController::class, "insert"]);
    Route::get("edit/{id}", [AdminNewsController::class, "edit"]);
    Route::post("edit", [AdminNewsController::class, "update"]);
    Route::post("delete", [AdminNewsController::class, "delete"]);

    Route::group(["prefix" => "type"], function () {
        Route::get("list", [NewsTypeController::class, "list"]);
        Route::get("add", [NewsTypeController::class, "add"]);
        Route::post("add", [NewsTypeController::class, "insert"]);
        Route::get("edit/{id}", [NewsTypeController::class, "edit"]);
        Route::post("edit", [NewsTypeController::class, "update"]);
        Route::post("delete", [NewsTypeController::class, "delete"]);
    });
});
