<?php
// app/Http/Controllers/Admin/News/NewsTypeController.php

namespace App\Http\Controllers\Admin\News;

use App\Http\Controllers\Controller;
use App\Models\News\NewsType;
use Illuminate\Http\Request;

class NewsTypeController extends Controller
{
    /**
     * ✅ 列表（含搜尋）
     * 對應：GET /admin/news/types
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $query = NewsType::query()->orderBy('id', 'desc');

        // ✅ 簡單搜尋（依 typeName）
        if ($q !== '') {
            $query->where('typeName', 'like', '%' . $q . '%');
        }

        $typeList = $query->get();

        return view('admin.news.newsType.list', compact('typeList', 'q'));
    }

    /**
     * ✅ 新增頁
     * 對應：GET /admin/news/types/create
     */
    public function create()
    {
        return view('admin.news.newsType.add');
    }

    /**
     * ✅ 新增送出
     * 對應：POST /admin/news/types
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'typeName' => ['required', 'string', 'max:50'],
        ], [
            'typeName.required' => '請輸入類別名稱',
        ]);

        // ⚠️ 注意：NewsType Model 需要有 $fillable = ['typeName'] 才能 create()
        NewsType::create([
            'typeName' => $validated['typeName'],
        ]);

        return redirect()->route('admin.news.types.index')
            ->with('success', '新增成功');
    }

    /**
     * ✅ 編輯頁
     * 對應：GET /admin/news/types/{id}/edit
     */
    public function edit(int $id)
    {
        $row = NewsType::findOrFail($id);

        return view('admin.news.newsType.edit', compact('row'));
    }

    /**
     * ✅ 更新（初學者：用 POST）
     * 對應：POST /admin/news/types/{id}/update
     */
    public function update(Request $request, int $id)
    {
        $row = NewsType::findOrFail($id);

        $validated = $request->validate([
            'typeName' => ['required', 'string', 'max:50'],
        ], [
            'typeName.required' => '請輸入類別名稱',
        ]);

        $row->typeName = $validated['typeName'];
        $row->save();

        return redirect()->route('admin.news.types.index')
            ->with('success', '更新成功');
    }

    /**
     * ✅ 刪除（初學者：用 POST）
     * 對應：POST /admin/news/types/{id}/delete
     */
    public function destroy(int $id)
    {
        $row = NewsType::findOrFail($id);
        $row->delete();

        return redirect()->route('admin.news.types.index')
            ->with('success', '刪除成功');
    }
}
