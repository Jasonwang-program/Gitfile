<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; // ✅ 讓 DB::table() 正常且 IDE 不再警告

class News extends Model
{
    /**
     * ✅ 指定資料表名稱
     * 注意：如果你的資料表名稱不是 news，就要改這行
     */
    protected $table = 'news';

    /**
     * ✅ 主鍵欄位（通常是 id）
     */
    protected $primaryKey = 'id';

    /**
     * ✅ 你的資料表只有 createTime，沒有 Laravel 預設的 created_at / updated_at
     * 所以要關掉 timestamps，否則 Laravel 會一直找 created_at / updated_at
     */
    public $timestamps = false;

    /**
     * ✅ 可批次寫入欄位（非常重要）
     * 注意：欄位名稱要「完全」跟資料庫一致（大小寫也要一致）
     * 你目前資料表欄位是：typeId、title、content、photo、createTime
     * 所以這裡就要這樣寫
     */
    protected $fillable = [
        'typeId',
        'title',
        'content',
        'photo',
        'createTime',
    ];

    /**
     * 最新消息列表查詢（含分類名稱 typeName）
     * 初學者先用 join 很 OK，後面想升級再改成 Eloquent 關聯也行
     */
    public function getList()
    {
        // a = news 表；b = news_type 表
        $list = DB::table($this->table . ' as a')
            // 取出 news 全欄位，再加上分類名稱 typeName
            ->selectRaw('a.*, b.typeName')
            // news.typeId 對到 news_type.id
            ->join('news_type as b', 'a.typeId', '=', 'b.id')
            // 依 createTime 由新到舊
            ->orderBy('a.createTime', 'desc')
            ->get();

        return $list;
    }
}
