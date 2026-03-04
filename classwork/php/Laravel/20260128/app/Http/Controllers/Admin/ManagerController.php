<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ManagerController extends Controller
{
    // ✅ 記住我 cookie 名稱（可改）
    private const REMEMBER_COOKIE = 'admin_remember';

    // ✅ 記住我天數（可改）
    private const REMEMBER_DAYS = 30;

    public function index(Request $request)
    {
        $userId = $request->session()->get('admin_userId');

        if (!$userId) {
            $userId = $this->tryLoginFromRememberCookie($request);
        }

        if (!$userId) {
            return redirect()->route('admin.login');
        }

        // ✅ 主後台唯一首頁：admin.index
        return view('admin.index', [
            'userId' => $userId,
        ]);
    }

    public function showLogin(\Illuminate\Http\Request $request)
    {
        // ✅ force=1 時：即使已登入也要顯示登入頁（方便看驗證碼）
        if ($request->boolean('force')) {
            return view('admin.login');
        }

        // 原本你可能有「已登入就導回後台」的邏輯（保留）
        if (session()->has('manager')) {
            return redirect()->route('admin.index');
        }

        return view('admin.login');
    }

    public function doLogin(Request $request)
    {
        // ✅ 驗證碼不分大小寫（後端）
        // 1) 使用者輸入統一轉小寫
        $request->merge([
            'code' => strtolower(trim((string) $request->input('code', ''))),
        ]);

        // 2) 強制把 captcha 設定成不分大小寫（就算你沒有 publish config/captcha.php 也有效）
        $captchaCfg = config('captcha');
        if (is_array($captchaCfg)) {
            foreach ($captchaCfg as $style => $cfg) {
                if (is_array($cfg)) {
                    config(["captcha.{$style}.sensitive" => false]);
                }
            }
        }
        config(['captcha.sensitive' => false]); // 再補一層保險

        $request->validate([
            'userId' => ['required'],
            'pwd'    => ['required'],
            'code'   => ['required', 'captcha'],
        ], [
            'userId.required' => '請輸入帳號',
            'pwd.required'    => '請輸入密碼',
            'code.required'   => '請輸入圖形驗證碼',
            'code.captcha'    => '圖形驗證碼不正確，請再試一次',
        ]);

        $inputUser = (string) $request->input('userId');
        $inputPwd  = (string) $request->input('pwd');

        $adminUser = (string) env('ADMIN_USERID', 'admin');
        $adminPwd  = (string) env('ADMIN_PASSWORD', '123456');

        $isOk = hash_equals($adminUser, $inputUser) && hash_equals($adminPwd, $inputPwd);

        if (!$isOk) {
            return back()
                ->withInput($request->only('userId', 'remember'))
                ->withErrors([
                    'login' => '帳號或密碼錯誤，請再試一次。',
                ]);
        }

        // ✅ 登入成功：重生 session（避免 session fixation）
        $request->session()->regenerate();
        $request->session()->put('admin_userId', $inputUser);

        $remember = $request->boolean('remember');
        if ($remember) {
            $minutes = self::REMEMBER_DAYS * 24 * 60;
            Cookie::queue(self::REMEMBER_COOKIE, $inputUser, $minutes);
        } else {
            Cookie::queue(Cookie::forget(self::REMEMBER_COOKIE));
        }

        // ✅ 登入後導向主後台首頁（唯一入口）
        return redirect()->route('admin.index');
    }

    public function logout(Request $request)
    {
        // ✅ 登出：清 session + 作廢 session + 重新產生 token
        $request->session()->forget('admin_userId');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Cookie::queue(Cookie::forget(self::REMEMBER_COOKIE));

        return redirect()->route('admin.login');
    }

    private function tryLoginFromRememberCookie(Request $request): ?string
    {
        $userId = $request->cookie(self::REMEMBER_COOKIE);

        if (is_string($userId) && trim($userId) !== '') {
            // ✅ 記住我登入：同樣先 regenerate，再寫入 session
            $request->session()->regenerate();
            $request->session()->put('admin_userId', $userId);
            return $userId;
        }

        return null;
    }

    public function showForgot()
    {
        return view('admin.forgot');
    }

    public function showRegister()
    {
        return view('admin.register');
    }
}
