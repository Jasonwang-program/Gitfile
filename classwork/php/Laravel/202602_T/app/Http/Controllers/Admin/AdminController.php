<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Manager;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view("admin.login");
    }

    public function login(Request $req)
    {
        /*
            一個等於:設定的意思, 將=右邊的資料設定給左邊的變數
            二個等於：左右兩邊的值相等
            三個等於：左右兩邊的值相等，且資料型態相同
        */

        // 帳號
        $userId = $req->userId;
        // 密碼
        $pwd = $req->pwd;
        // 認證碼
        $code = $req->code;
        // 檢查所輸入的驗證碼是否與系統產出的驗證碼相同
        if (captcha_check($code) == false) {
            // 輸入錯的驗證碼
            // back:回到上一頁
            // withInput: 保留上一頁所輸入的資料
            // withErrors: 最後一個字有s，回傳錯誤訊息
            // exit: 程式結束，不再往下執行
            // []: 中括號為陣列
            return back()->withInput()->withErrors(["msg" => "驗證碼錯誤"]);
            exit;
        }

        /*
            $manager = (new Manager())->getManager($userId, $pwd)

            $member = new Manager();
            $manager = $member->getManager($userId, $pwd);
        */
        $manager = (new Manager())->getManager($userId, $pwd);
        // empty: 空的,也就是沒資料
        if (empty($manager))
        {
            return back()->withInput()->withErrors(["account" => "帳號或密碼錯誤"]);
            exit;
        }else{
            // 登入成功
            session()->put("managerId", $userId);
            return redirect("/admin/home");
        }
    }

    public function home()
    {
        return view("admin.home1");
    }
}
