<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    public $timestamps = false;
    protected $table = "manager";
    protected $primaryKey = 'userId';
    protected $fillable = ["userId", "pwd"];

    public function getManager($userId, $pwd)
    {
        // SELECT * FROM manager WHERE userId = $userId AND pwd = $pwd LIMIT 1;
        // first():取第一筆
        // self::manager這個資料表
        /*
            第二種方式
            DB::select("SELECT * FROM manager WHERE userId = $userId AND pwd = $pwd LIMIT 1");

            第三種方式
            DB::table("manager")->where("userId", $userId)->where("pwd", $pwd)->first();
        */  
        $manager = self::where("userId", $userId)->where("pwd", $pwd)->first();
        return $manager;
    }
}
