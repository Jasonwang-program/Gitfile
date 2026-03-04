<?php

namespace App\Http\Controllers\Admin\News;

use App\Http\Controllers\Controller;
use App\Models\News\News;
use App\Models\News\NewsType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminNewsController extends Controller
{
    public function list()
    {
        $list = (new News())->getList();
        return view("admin.news.list", compact("list"));
    }

    public function add()
    {
        $list = NewsType::get();
        return view("admin.news.add", compact("list"));
    }

    public function insert(Request $req)
    {
        $photo = $req->photo;

        /*
            owner   group   others
            7       7         7
            7 = 4+2+1 (4:讀  2:寫  1:執行)
        */
        // 在public資料夾下, 若images資料夾不存在,則建立images資料夾
        if (!file_exists("images"))
        {
            mkdir("images", 0777);
        }
        // 在public/images資料夾下, 若news資料夾不存在,則建立news資料夾
        if (!file_exists("images/news"))
        {
            mkdir("images/news", 0777);
        }

        // extension:原始檔的副檔名
        // 將上傳的檔名更改為以時間序列為名稱
        $fileName = time() . "." . $photo->extension();
        // 將上傳的檔案由電腦的暫存區(如果是xampp,則暫存區通常在C:\xampp\tmp), 搬移到專案的public/images/news資料夾下
        $photo->move("images/news", $fileName);

        // 內容
        $content = $req->content;
        // 如果有輸入內容
        if (!empty($content))
        {
            //將html的換行(\n), 轉為網頁的換行(<br/>)
            $content = str_replace("\n", "<br/>", $content);
        }

        $news = new News();
        $news->typeId = $req->typeId;
        $news->title = $req->title;
        $news->content = $content;
        $news->photo = $fileName;
        $news->save();

        Session::flash("message", "已新增");
        return redirect("/admin/news/list");
    }

    public function edit(Request $req)
    {
        $news = News::find($req->id);
        $list = NewsType::get();
        return view("admin.news.edit", compact("news", "list"));
    }
}
