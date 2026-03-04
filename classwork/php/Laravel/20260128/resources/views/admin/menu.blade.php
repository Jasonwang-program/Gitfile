{{-- resources/views/admin/menu.blade.php --}}

@php
    $userId = session('admin_userId') ?? 'admin';

    $isDashboard = request()->routeIs('admin.index');
    $isNewsTypes = request()->routeIs('admin.news.types.*');
    $isNews = request()->routeIs('admin.news.*');
    $isAbout = request()->routeIs('admin.about');
    $isProducts = request()->routeIs('admin.products');
@endphp

<style>
    .brand {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        background: rgba(255, 255, 255, .4);
    }

    .logo {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--brand) 0%, var(--brand2) 55%, #a7f3d0 120%);
        box-shadow: 0 8px 16px rgba(45, 106, 79, .2);
        position: relative;
        overflow: hidden;
        flex: 0 0 auto;
    }

    .logo:after {
        content: "";
        position: absolute;
        inset: -40%;
        background: radial-gradient(circle, rgba(255, 255, 255, .4), transparent 60%);
        transform: rotate(25deg);
    }

    .brand .title {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }

    .brand .title b {
        font-size: 15px;
        letter-spacing: .4px;
    }

    .brand .title span {
        font-size: 12px;
        color: var(--muted);
        margin-top: 3px;
    }

    .menu {
        padding: 6px;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        background: rgba(255, 255, 255, .3);
        overflow: auto;
        min-height: 220px;
    }

    .section {
        margin: 8px 6px 10px;
        font-size: 12px;
        color: var(--muted2);
        letter-spacing: .5px;
        text-transform: uppercase;
    }

    .item,
    .subitem {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 10px 10px;
        border-radius: 12px;
        color: var(--text);
        text-decoration: none;
        background: transparent;
        border: 1px solid transparent;
        cursor: pointer;
        user-select: none;
        transition: .18s ease;
        font-size: 14px;
    }

    .item:hover,
    .subitem:hover {
        background: rgba(255, 255, 255, .5);
        border-color: rgba(45, 106, 79, .1);
        transform: translateY(-1px);
    }

    .item.active,
    .subitem.active {
        background: rgba(45, 106, 79, .12);
        border-color: rgba(45, 106, 79, .25);
        box-shadow: 0 0 0 4px rgba(45, 106, 79, .08);
        color: var(--brand);
    }

    .left {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .icon {
        width: 26px;
        height: 26px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(45, 106, 79, .08);
        border: 1px solid rgba(45, 106, 79, .1);
        color: var(--brand);
        flex: 0 0 auto;
    }

    .label {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .label b {
        font-weight: 600;
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .label span {
        font-size: 12px;
        color: var(--muted);
        margin-top: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .chev {
        width: 26px;
        height: 26px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--muted);
        background: rgba(255, 255, 255, .4);
        border: 1px solid var(--border);
        flex: 0 0 auto;
    }

    .submenu {
        margin: 6px 0 10px 38px;
        padding-left: 10px;
        border-left: 1px dashed var(--border);
        display: none;
    }

    .submenu.open {
        display: block
    }

    .sidebarFooter {
        margin-top: auto;
        padding: 12px;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        background: rgba(255, 255, 255, .4);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .who {
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .who .user {
        font-size: 13px;
        color: var(--text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .who .hint {
        font-size: 12px;
        color: var(--muted);
    }
</style>

<div class="brand">
    <div class="logo"></div>
    <div class="title">
        <b>網站後台管理</b>
        <span>內容管理 CMS（示範版）</span>
    </div>
</div>

<div class="menu" id="adminMenu">
    <div class="section">內容管理</div>

    <a class="item {{ $isDashboard ? 'active' : '' }}" href="{{ route('admin.index') }}">
        <div class="left">
            <div class="icon">📊</div>
            <div class="label">
                <b>儀表板</b>
                <span>總覽、狀態、快捷</span>
            </div>
        </div>
        <div class="chev">›</div>
    </a>

    <button class="item {{ $isNewsTypes || $isNews ? 'active' : '' }}" type="button" data-toggle="news">
        <div class="left">
            <div class="icon">📰</div>
            <div class="label">
                <b>最新消息</b>
                <span>文章、分類、發布狀態</span>
            </div>
        </div>
        <div class="chev">▾</div>
    </button>

    <div class="submenu {{ $isNewsTypes || $isNews ? 'open' : '' }}" data-submenu="news">
        <a class="subitem {{ $isNewsTypes ? 'active' : '' }}" href="{{ route('admin.news.types.index') }}">
            <div class="left">
                <div class="icon">🏷️</div>
                <div class="label">
                    <b>最新消息管理類別</b>
                    <span>新增 / 編輯 / 排序</span>
                </div>
            </div>
        </a>

        <a class="subitem {{ $isNews ? 'active' : '' }}" href="{{ route('admin.news.index') }}">
            <div class="left">
                <div class="icon">📝</div>
                <div class="label">
                    <b>最新消息管理</b>
                    <span>列表 / 新增 / 發佈</span>
                </div>
            </div>
        </a>
    </div>

    <a class="item {{ $isAbout ? 'active' : '' }}" href="{{ route('admin.about') }}">
        <div class="left">
            <div class="icon">ℹ️</div>
            <div class="label">
                <b>關於我們</b>
                <span>公司簡介 / 里程碑</span>
            </div>
        </div>
        <div class="chev">›</div>
    </a>

    <a class="item {{ $isProducts ? 'active' : '' }}" href="{{ route('admin.products') }}">
        <div class="left">
            <div class="icon">📦</div>
            <div class="label">
                <b>產品介紹</b>
                <span>分類 / 產品 / 圖片</span>
            </div>
        </div>
        <div class="chev">›</div>
    </a>

    <div class="section">系統</div>

    {{-- ✅ 只保留「回登入頁」即可（不再提供 home 保留頁） --}}
    <a class="item" href="{{ route('admin.login') }}">
        <div class="left">
            <div class="icon">🔐</div>
            <div class="label">
                <b>回登入頁</b>
                <span>查看登入 / 驗證碼</span>
            </div>
        </div>
        <div class="chev">›</div>
    </a>
</div>

<div class="sidebarFooter">
    <div class="who">
        <div class="user">👤 {{ $userId }}</div>
        <div class="hint">已登入（Session / Remember）</div>
    </div>
</div>

@push('scripts')
    <script>
        (function() {
            const root = document.getElementById('adminMenu');
            if (!root) return;

            root.addEventListener('click', function(e) {
                const btn = e.target.closest('[data-toggle]');
                if (!btn) return;

                const key = btn.getAttribute('data-toggle');
                const submenu = root.querySelector('[data-submenu="' + key + '"]');
                if (!submenu) return;

                submenu.classList.toggle('open');
            });
        })();
    </script>
@endpush
