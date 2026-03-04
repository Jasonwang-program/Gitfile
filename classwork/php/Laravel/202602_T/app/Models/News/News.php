<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class News extends Model
{
    public $timestamps = false;
    protected $table = "news";
    protected $primaryKey = "id";
    protected $fillable = ["id", "typeId", "title", "content", "photo", "createTime"];

    public function getList()
    {
        // $this->table : news資料表
        // get:取得全部資料
        // SELECT a.*, b.typeName FROM news AS a INNER JOIN news_type AS b ON a.typeId = b.id ORDER BY a.createTime DESC
        $list = DB::table("$this->table AS a")
            // 也可用->select("a.*", "b.typeName")
            ->selectRaw("a.*, b.typeName")
            ->join("news_type AS b", "a.typeId", "b.id")
            //->orderby("a.typeId", "ASC") // ASC:如果沒有註明ASC, 則預設為ASC, 從小到大排序; DESC: 從大到小排序
            ->orderby("a.createTime", "DESC")
            ->get();

        return $list;
    }
}
