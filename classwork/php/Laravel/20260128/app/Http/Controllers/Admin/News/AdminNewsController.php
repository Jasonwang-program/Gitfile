<?php

namespace App\Http\Controllers\Admin\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\News\News;
use App\Models\News\NewsType;

class AdminNewsController extends Controller
{
    /**
     * 最新消息列表（小超越：顯示分類名稱 + 搜尋標題）
     */
    public function index(Request $request)
    {
        // ✅ 小超越：做一個簡單搜尋（只搜標題）
        $q = trim($request->get('q', ''));

        $rows = DB::table('news as a')
            ->selectRaw('a.*, b.typeName')
            ->leftJoin('news_type as b', 'a.typeId', '=', 'b.id')
            ->when($q !== '', function ($query) use ($q) {
                // 中文注意：LIKE 搜尋標題
                $query->where('a.title', 'like', '%' . $q . '%');
            })
            ->orderBy('a.createTime', 'desc')
            ->get();

        return view('admin.news.news.list', compact('rows', 'q'));
    }

    /**
     * 新增頁（需要分類下拉選單）
     */
    public function create()
    {
        $types = NewsType::query()
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.news.news.create', compact('types'));
    }

    /**
     * 新增送出
     */
    public function store(Request $request)
    {
        // ✅ 初學者版驗證（夠用、不複雜）
        $validated = $request->validate([
            'typeId'  => ['required', 'integer'],
            'title'   => ['required', 'string', 'max:100'],
            'content' => ['required', 'string'],
            'photo'   => ['nullable', 'string', 'max:30'], // 先當作「檔名」欄位，不做上傳
        ], [
            'typeId.required'  => '請選擇分類',
            'title.required'   => '請輸入標題',
            'content.required' => '請輸入內容',
        ]);

        // ✅ createTime 你資料表有預設 current_timestamp()，其實可以不用塞
        News::create([
            'typeId'   => $validated['typeId'],
            'title'    => $validated['title'],
            'content'  => $validated['content'],
            'photo'    => $validated['photo'] ?? '',
            // 'createTime' => now(), // 不塞也行（DB會自動給）
        ]);

        return redirect()->route('admin.news.index')->with('success', '新增成功');
    }

    /**
     * 刪除（先做硬刪，保持簡單）
     */
    public function destroy($id)
    {
        News::where('id', $id)->delete();
        return redirect()->route('admin.news.index')->with('success', '刪除成功');
    }
}
