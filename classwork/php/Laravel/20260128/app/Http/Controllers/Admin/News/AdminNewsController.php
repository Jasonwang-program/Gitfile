<?php

namespace App\Http\Controllers\Admin\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

use App\Models\News\News;
use App\Models\News\NewsType;

use App\Exports\NewsExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminNewsController extends Controller
{
    /**
     * 列表（含分類名稱 + 搜尋標題）
     * GET /admin/news/list
     */
    public function list(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $rows = DB::table('news as a')
            ->selectRaw('a.*, b.typeName')
            ->leftJoin('news_type as b', 'a.typeId', '=', 'b.id')
            ->when($q !== '', function ($query) use ($q) {
                $query->where('a.title', 'like', '%' . $q . '%');
            })
            ->orderBy('a.createTime', 'desc')
            ->get();

        return view('admin.news.news.list', compact('rows', 'q'));
    }

    /**
     * 新增頁
     * GET /admin/news/add
     */
    public function add()
    {
        $types = NewsType::query()->orderBy('id', 'desc')->get();
        return view('admin.news.news.create', compact('types'));
    }

    /**
     * ✅ 新增送出（穩定版：真的上傳圖片）
     * POST /admin/news/add
     */
    public function insert(Request $request)
    {
        $validated = $request->validate([
            'typeId'  => ['required', 'integer'],
            'title'   => ['required', 'string', 'max:100'],
            'content' => ['required', 'string'],
            'photo'   => ['nullable', 'image', 'max:5120'], // 5MB
        ], [
            'typeId.required'  => '請選擇分類',
            'title.required'   => '請輸入標題',
            'content.required' => '請輸入內容',
            'photo.image'      => '圖片格式不正確（請上傳 jpg/png/webp 等）',
        ]);

        // 內容：編輯方便的換行 -> 存 DB 時統一用 <br/>
        $content = str_replace(["\r\n", "\r", "\n"], "<br/>", (string) $validated['content']);

        // 圖片：預設空字串（代表沒上傳）
        $fileName = '';

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $dir = public_path('images/news');
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $photo = $request->file('photo');
            $ext = strtolower($photo->getClientOriginalExtension());
            if ($ext === '') $ext = 'jpg';

            $fileName = date('Ymd_His') . '_' . Str::random(6) . '.' . $ext;
            $photo->move($dir, $fileName);
        }

        $news = new News();
        $news->typeId  = (int) $validated['typeId'];
        $news->title   = (string) $validated['title'];
        $news->content = $content;
        $news->photo   = $fileName; // ✅ DB 只存「檔名」
        $news->save();

        Session::flash('message', '已新增');
        return redirect('/admin/news/list');
    }

    /**
     * 編輯頁
     * GET /admin/news/edit/{id}
     */
    public function edit($id)
    {
        $news = News::find($id);
        $types = NewsType::query()->orderBy('id', 'desc')->get();
        return view('admin.news.news.edit', compact('news', 'types'));
    }

    /**
     * ✅ 更新送出（穩定版：可換圖、沒換圖保留舊圖、刪舊圖安全）
     * POST /admin/news/edit
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id'        => ['required', 'integer'],
            'typeId'    => ['required', 'integer'],
            'title'     => ['required', 'string', 'max:100'],
            'content'   => ['required', 'string'],
            'photo_old' => ['nullable', 'string', 'max:255'],
            'photo'     => ['nullable', 'image', 'max:5120'],
        ]);

        $news = News::find($validated['id']);
        if (!$news) {
            Session::flash('message', '找不到資料');
            return redirect('/admin/news/list');
        }

        $content = str_replace(["\r\n", "\r", "\n"], "<br/>", (string) $validated['content']);

        $news->typeId  = (int) $validated['typeId'];
        $news->title   = (string) $validated['title'];
        $news->content = $content;

        // 先預設保留舊圖（避免沒上傳就把 photo 清空）
        $fileName = (string) ($validated['photo_old'] ?? $news->photo ?? '');

        // 有新圖才換
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $dir = public_path('images/news');
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $photo = $request->file('photo');
            $ext = strtolower($photo->getClientOriginalExtension());
            if ($ext === '') $ext = 'jpg';

            $newFileName = date('Ymd_His') . '_' . Str::random(6) . '.' . $ext;
            $photo->move($dir, $newFileName);

            // 刪舊圖（安全：先檢查存在）
            if (!empty($news->photo)) {
                $oldPath = public_path('images/news/' . $news->photo);
                if (is_file($oldPath)) {
                    unlink($oldPath);
                }
            }

            $fileName = $newFileName;
        }

        $news->photo = $fileName;
        $news->save();

        Session::flash('message', '已修改');
        return redirect('/admin/news/list');
    }

    /**
     * ✅ 批次刪除（勾選 id[]）
     * POST /admin/news/delete
     */
    public function delete(Request $request)
    {
        // ✅ 對應 list.blade：name="id[]"
        $ids = $request->input('id', []);
        if (!is_array($ids)) $ids = [$ids];

        foreach ($ids as $id) {
            $news = News::find($id);
            if (!$news) continue;

            // 刪圖片（安全）
            if (!empty($news->photo)) {
                $path = public_path('images/news/' . $news->photo);
                if (is_file($path)) {
                    unlink($path);
                }
            }

            $news->delete();
        }

        Session::flash('message', '已刪除');
        return redirect('/admin/news/list');
    }

    /**
     * 匯出 Excel
     * GET /admin/news/export
     */
    public function export()
    {
        return Excel::download(new NewsExport, '最新消息.xlsx');
    }
}
