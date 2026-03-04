{{-- resources/views/admin/index.blade.php --}}
@extends('admin.layout')

@section('page_title', '後台管理 - 儀表板')
@section('header_title', '儀表板')
@section('header_desc', '後台總覽、快捷入口與系統狀態')

@section('content')
    @php
        $userId = $userId ?? (session('admin_userId') ?? 'admin');
    @endphp

    <div class="grid cols4">
        <div class="card">
            <b>今日訪客</b>
            <div class="big">—</div>
            <div class="muted">之後可串 Google Analytics 或自建 log。</div>
        </div>

        <div class="card">
            <b>最新消息</b>
            <div class="big">—</div>
            <div class="muted">之後接 DB：news / categories。</div>
        </div>

        <div class="card">
            <b>產品數</b>
            <div class="big">—</div>
            <div class="muted">之後接 DB：products / images。</div>
        </div>

        <div class="card">
            <b>登入身分</b>
            <div class="big">{{ $userId }}</div>
            <div class="muted">目前為單一帳密登入示範。</div>
        </div>
    </div>

    <div class="hr"></div>

    <div class="grid cols2">
        <div class="card">
            <b>🚀 快捷入口</b>
            <div class="muted" style="margin-bottom:10px;">把「#」換成 route() 就能變成真的管理頁（目前已接好路由）。</div>

            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <a class="btn" href="{{ route('admin.news.types.index') }}">最新消息管理類別</a>
                <a class="btn" href="{{ route('admin.news.index') }}">最新消息管理</a>
                <a class="btn" href="{{ route('admin.about') }}">關於我們</a>
                <a class="btn" href="{{ route('admin.products') }}">產品介紹</a>
            </div>

            <div class="hr"></div>

            <div class="muted">
                提示：目前專案把「路由與登入保護」先整理好。下一步你要做 CRUD 時，我可以依你選單順序（最新消息 / 關於我們 / 產品介紹）逐一幫你建 migration、model、controller、views。
            </div>
        </div>

        <div class="card">
            <b>🧩 系統資訊（示範）</b>
            <div class="hr"></div>
            <div class="muted">PHP：<code>{{ PHP_VERSION }}</code></div>
            <div class="muted" style="margin-top:6px;">Laravel：<code>{{ app()->version() }}</code></div>
            <div class="muted" style="margin-top:6px;">APP_DEBUG：<code>{{ config('app.debug') ? 'true' : 'false' }}</code>
            </div>
            <div class="muted" style="margin-top:6px;">更新時間：<code>{{ now()->format('Y-m-d H:i') }}</code></div>

            <div class="hr"></div>

            <a class="btn" href="{{ route('admin.news.types.index') }}">下一步：接 DB / CRUD</a>
        </div>
    </div>
@endsection
