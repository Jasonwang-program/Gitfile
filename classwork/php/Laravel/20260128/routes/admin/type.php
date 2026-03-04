Route::group(['middleware' => 'manager', 'prefix' => 'admin/news/type'], function () {
Route::get('list', [NewsTypeController::class, 'list']);
Route::get('add', [NewsTypeController::class, 'add']);
Route::post('add', [NewsTypeController::class, 'store']); // 新增送出
});