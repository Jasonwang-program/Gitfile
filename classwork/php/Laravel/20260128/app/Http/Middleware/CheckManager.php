<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckManager
{
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ 你登入後存的是 admin_userId
        $uid = $request->session()->get('admin_userId');

        if (empty($uid)) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
