<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    //不要使用 Laravel 預設的二個時間欄位(create_at及update_at)
    public $timestamps = false;
    //資料表名稱
    protected $table = 'manager';
    //主鍵名稱
    protected $primaryKey = 'userId';
    //資料表欄位
    protected $fillable = ['userId', 'pwd'];
    //驗證管理者帳號密碼
    public function checkManager($userId, $pwd) // getManager 也可以
    {
        // 第一種方式：
        // SELECT * FROM manager WHERE userId = $userId AND pwd = $pwd LIMIT 1;
        // first()::取第一筆資料
        // self::manager這個資料表 (self可表示物件自己本身)
        // 第二種方式：
        // DB::select("SELECT * FROM manager WHERE userId = $userId = $userId AND pwd = LIMIT 1");
        // 第三種方式：
        // DB::table("manager")->where('userId', $userId)->where('pwd', $pwd)->first();
        // ::表示是靜態的(static)
        $manager = self::where('userId', $userId)->where('pwd', $pwd)->first();
        // return::回傳查詢結果
        return $manager;
    }
}
