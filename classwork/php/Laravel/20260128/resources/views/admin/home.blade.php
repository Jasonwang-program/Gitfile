{{-- resources/views/admin/home.blade.php --}}

<!doctype html>
<html lang="zh-TW">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>後台儀表板</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            /* 核心底色改為 #98d496 */
            --bg: #98d496;
            --panel: rgba(255, 255, 255, .75);
            --panel2: rgba(255, 255, 255, .55);
            --border: rgba(45, 85, 48, .12);
            --text: #1a2e1c;
            --muted: #4b634d;
            --muted2: #607d62;
            --brand: #2d6a4f;
            --brand2: #40916c;
            --ring: rgba(45, 106, 79, .25);
            --ok: #059669;
            --danger: #dc2626;
            --shadow: 0 15px 40px rgba(45, 85, 48, .15);
            --radius: 18px;
            --radius2: 14px;
            --font: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Noto Sans TC", sans-serif;
        }

        * {
            box-sizing: border-box
        }

        html,
        body {
            height: 100%
        }

        body {
            margin: 0;
            font-family: var(--font);
            color: var(--text);
            /* 修改漸層為亮色系綠色調 */
            background:
                radial-gradient(1200px 800px at 12% 10%, rgba(255, 255, 255, .4), transparent 55%),
                radial-gradient(900px 600px at 85% 15%, rgba(45, 106, 79, .15), transparent 55%),
                radial-gradient(900px 700px at 45% 85%, rgba(255, 255, 255, .3), transparent 55%),
                var(--bg);
            overflow: hidden;
        }

        .app {
            height: 100%;
            display: grid;
            grid-template-columns: 290px 1fr;
        }

        @media (max-width:980px) {
            body {
                overflow: auto
            }

            .app {
                grid-template-columns: 1fr
            }

            .sidebar {
                position: sticky;
                top: 0;
                z-index: 10
            }
        }

        .sidebar {
            border-right: 1px solid var(--border);
            /* 側邊欄改為亮色半透明 */
            background: rgba(255, 255, 255, .65);
            backdrop-filter: blur(16px);
            padding: 20px 18px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            box-shadow: 10px 0 50px rgba(0, 0, 0, .05);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 12px;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            background: rgba(255, 255, 255, .4);
        }

        .logo {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            /* Logo 顏色調整為綠色系漸層 */
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

        .menu .section {
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
            /* 啟用狀態改為淡綠色背景 */
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
            transition: .18s ease;
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

        .subitem {
            padding: 9px 10px;
            font-size: 13px;
            border-radius: 12px;
        }

        .subitem .icon {
            width: 22px;
            height: 22px;
            border-radius: 9px;
            color: var(--brand2);
        }

        .sidebarFooter {
            margin-top: auto;
            padding: 12px 12px;
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

        .btn {
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, .8);
            color: var(--text);
            padding: 10px 12px;
            border-radius: 12px;
            cursor: pointer;
            transition: .18s ease;
            font-size: 13px;
            white-space: nowrap;
        }

        .btn:hover {
            transform: translateY(-1px);
            border-color: var(--brand);
            box-shadow: 0 0 0 4px var(--ring);
        }

        .btn.danger:hover {
            border-color: var(--danger);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(220, 38, 38, .1);
        }

        .main {
            height: 100%;
            display: grid;
            grid-template-rows: 72px 1fr;
            overflow: hidden;
        }

        .topbar {
            border-bottom: 1px solid var(--border);
            background: rgba(255, 255, 255, .4);
            backdrop-filter: blur(16px);
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .topbar .pageTitle {
            display: flex;
            flex-direction: column;
            gap: 2px;
            min-width: 0;
        }

        .topbar .pageTitle b {
            font-size: 16px;
            letter-spacing: .2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .topbar .pageTitle span {
            font-size: 12px;
            color: var(--muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .topbarRight {
            display: flex;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
        }

        .pill {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 9px 12px;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, .5);
            color: var(--muted);
            font-size: 12px;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 99px;
            background: var(--ok);
            box-shadow: 0 0 0 4px rgba(5, 150, 105, .15);
        }

        .content {
            padding: 18px;
            overflow: auto;
        }

        /* Dashboard */
        .dashGrid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 16px;
        }

        @media (max-width:980px) {
            .dashGrid {
                grid-template-columns: repeat(1, 1fr);
            }
        }

        .stat,
        .panel,
        .side {
            grid-column: span 3;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            background: var(--panel);
            backdrop-filter: blur(14px);
            box-shadow: var(--shadow);
            padding: 16px;
        }

        @media (max-width:980px) {

            .stat,
            .panel,
            .side {
                grid-column: span 12;
            }
        }

        .panel {
            grid-column: span 8;
        }

        .side {
            grid-column: span 4;
        }

        .stat .k {
            font-size: 12px;
            color: var(--muted);
        }

        .stat .v {
            margin-top: 10px;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: .3px;
            color: var(--brand);
        }

        .stat .s {
            margin-top: 10px;
            font-size: 12px;
            color: var(--muted2);
            line-height: 1.6;
        }

        .h {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .h h3 {
            margin: 0;
            font-size: 14px;
            letter-spacing: .2px;
            color: var(--brand);
        }

        .h .hint {
            font-size: 12px;
            color: var(--muted);
        }

        .qa {
            margin-top: 12px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        @media (max-width:980px) {
            .qa {
                grid-template-columns: 1fr;
            }
        }

        .q {
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 12px;
            background: rgba(255, 255, 255, .6);
            text-decoration: none;
            color: var(--text);
            transition: .18s ease;
        }

        .q:hover {
            transform: translateY(-1px);
            border-color: var(--brand);
            box-shadow: 0 0 0 4px var(--ring);
            background: #fff;
        }

        .q b {
            display: block;
            font-size: 13px;
            margin-bottom: 3px;
            color: var(--brand2);
        }

        .q span {
            font-size: 12px;
            color: var(--muted);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px 10px;
            border-bottom: 1px solid var(--border);
            font-size: 13px;
        }

        th {
            color: var(--muted2);
            text-align: left;
            font-weight: 600;
        }

        td {
            color: var(--text);
        }

        .badge {
            font-size: 11px;
            padding: 6px 10px;
            border-radius: 999px;
            border: 1px solid rgba(45, 106, 79, .25);
            background: rgba(45, 106, 79, .1);
            color: var(--brand);
            white-space: nowrap;
        }

        code {
            background: rgba(45, 106, 79, .08);
            border: 1px solid rgba(45, 106, 79, .12);
            padding: 2px 7px;
            border-radius: 10px;
            color: var(--brand);
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="app">
        {{-- Sidebar --}}
        <aside class="sidebar">
            <div class="brand">
                <div class="logo" aria-hidden="true"></div>
                <div class="title">
                    <b>網站後台管理</b>
                    <span>內容管理 CMS（示範版）</span>
                </div>
            </div>

            <nav class="menu" aria-label="後台選單">
                <div class="section">內容管理</div>

                {{-- 儀表板 --}}
                <a class="item active" href="{{ route('admin.home') }}">
                    <span class="left">
                        <span class="icon" aria-hidden="true">📊</span>
                        <span class="label">
                            <b>儀表板</b>
                            <span>總覽、狀態、快捷</span>
                        </span>
                    </span>
                    <span class="chev" aria-hidden="true">›</span>
                </a>

                {{-- 最新消息 --}}
                <button type="button" class="item" data-menu="news" aria-expanded="false">
                    <span class="left">
                        <span class="icon" aria-hidden="true">📰</span>
                        <span class="label">
                            <b>最新消息</b>
                            <span>文章、分類、發布狀態</span>
                        </span>
                    </span>
                    <span class="chev" aria-hidden="true">▾</span>
                </button>

                <div class="submenu" data-submenu="news">
                    <a class="subitem" href="#">
                        <span class="left">
                            <span class="icon" aria-hidden="true">🏷️</span>
                            <span class="label">
                                <b>最新消息管理類別</b>
                                <span>新增 / 編輯 / 排序</span>
                            </span>
                        </span>
                    </a>

                    <a class="subitem" href="#">
                        <span class="left">
                            <span class="icon" aria-hidden="true">🧾</span>
                            <span class="label">
                                <b>最新消息管理</b>
                                <span>列表 / 新增 / 發佈</span>
                            </span>
                        </span>
                    </a>
                </div>

                {{-- 關於我們 --}}
                <a class="item" href="#">
                    <span class="left">
                        <span class="icon" aria-hidden="true">ℹ️</span>
                        <span class="label">
                            <b>關於我們</b>
                            <span>公司簡介、里程碑</span>
                        </span>
                    </span>
                    <span class="chev" aria-hidden="true">›</span>
                </a>

                {{-- 產品介紹 --}}
                <a class="item" href="#">
                    <span class="left">
                        <span class="icon" aria-hidden="true">📦</span>
                        <span class="label">
                            <b>產品介紹</b>
                            <span>分類、產品、圖片</span>
                        </span>
                    </span>
                    <span class="chev" aria-hidden="true">›</span>
                </a>

                <div class="section" style="margin-top:14px;">系統</div>

                <a class="item" href="{{ route('admin.index') }}">
                    <span class="left">
                        <span class="icon" aria-hidden="true">🏠</span>
                        <span class="label">
                            <b>後台首頁</b>
                            <span>原本 index 頁</span>
                        </span>
                    </span>
                    <span class="chev" aria-hidden="true">›</span>
                </a>

                <a class="item" href="{{ route('admin.login') }}">
                    <span class="left">
                        <span class="icon" aria-hidden="true">🔐</span>
                        <span class="label">
                            <b>回登入頁</b>
                            <span>查看登入/驗證碼</span>
                        </span>
                    </span>
                    <span class="chev" aria-hidden="true">›</span>
                </a>
            </nav>

            <div class="sidebarFooter">
                <div class="who">
                    <div class="user">👤 {{ $userId ?? 'unknown' }}</div>
                    <div class="hint">已登入（Session / Remember）</div>
                </div>

                <form action="{{ route('admin.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn danger">登出</button>
                </form>
            </div>
        </aside>

        {{-- Main --}}
        <section class="main">
            {{-- Topbar --}}
            <header class="topbar">
                <div class="pageTitle">
                    <b>儀表板</b>
                    <span>後台總覽、快捷入口與系統狀態</span>
                </div>

                <div class="topbarRight">
                    <div class="pill" title="目前狀態（示範）">
                        <span class="dot" aria-hidden="true"></span>
                        <span>系統正常</span>
                    </div>
                    <div class="pill" title="環境資訊（示範）">
                        <span>ENV:</span>
                        <code>{{ config('app.env') }}</code>
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <main class="content">

                <div class="dashGrid">
                    {{-- Stats --}}
                    <div class="stat">
                        <div class="k">今日訪客</div>
                        <div class="v">—</div>
                        <div class="s">之後可串 Google Analytics 或自建 log。</div>
                    </div>

                    <div class="stat">
                        <div class="k">最新消息</div>
                        <div class="v">—</div>
                        <div class="s">之後接 DB：news / categories。</div>
                    </div>

                    <div class="stat">
                        <div class="k">產品數</div>
                        <div class="v">—</div>
                        <div class="s">之後接 DB：products / images。</div>
                    </div>

                    <div class="stat">
                        <div class="k">登入身分</div>
                        <div class="v" style="font-size:20px; line-height:1.3;">
                            {{ session('admin_userId') ?? '—' }}
                        </div>
                        <div class="s">目前為單一帳密登入示範。</div>
                    </div>

                    {{-- Panel --}}
                    <section class="panel">
                        <div class="h">
                            <h3>🚀 快捷入口</h3>
                            <div class="hint">把 # 換成 route() 就能變成真的管理頁</div>
                        </div>

                        <div class="qa">
                            <a class="q" href="#">
                                <b>最新消息管理類別</b>
                                <span>新增 / 編輯 / 排序</span>
                            </a>
                            <a class="q" href="#">
                                <b>最新消息管理</b>
                                <span>文章列表 / 發佈狀態</span>
                            </a>
                            <a class="q" href="#">
                                <b>關於我們</b>
                                <span>公司簡介 / 里程碑</span>
                            </a>
                            <a class="q" href="#">
                                <b>產品介紹</b>
                                <span>分類 / 產品 / 圖片</span>
                            </a>
                        </div>

                        <div style="margin-top:14px; color:var(--muted); font-size:13px; line-height:1.8;">
                            提示：目前專案把「路由與登入保護」先整理好。下一步你要做 CRUD 時，
                            我可以依你選單（最新消息、關於我們、產品介紹）逐一幫你建 migration、model、controller、views。
                        </div>
                    </section>

                    {{-- Side --}}
                    <aside class="side">
                        <div class="h">
                            <h3>🧩 系統資訊</h3>
                            <div class="hint">示範</div>
                        </div>

                        <div style="margin-top:12px;">
                            <table>
                                <tr>
                                    <th>PHP</th>
                                    <td>{{ PHP_VERSION }}</td>
                                </tr>
                                <tr>
                                    <th>Laravel</th>
                                    <td>{{ app()->version() }}</td>
                                </tr>
                                <tr>
                                    <th>APP_DEBUG</th>
                                    <td>{{ config('app.debug') ? 'true' : 'false' }}</td>
                                </tr>
                                <tr>
                                    <th>更新時間</th>
                                    <td>{{ now()->format('Y-m-d H:i') }}</td>
                                </tr>
                            </table>
                        </div>

                        <div style="margin-top:12px;">
                            <span class="badge">下一步：接 DB / CRUD</span>
                        </div>
                    </aside>

                    {{-- Recent Activity --}}
                    <section class="panel" style="grid-column: span 12;">
                        <div class="h">
                            <h3>🕒 最近活動（示範）</h3>
                            <div class="hint">之後可寫入 log table</div>
                        </div>

                        <div style="margin-top:12px; overflow:auto;">
                            <table>
                                <thead>
                                    <tr>
                                        <th style="width:220px;">時間</th>
                                        <th>事件</th>
                                        <th style="width:180px;">來源</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ now()->subMinutes(3)->format('Y-m-d H:i') }}</td>
                                        <td>登入成功</td>
                                        <td>127.0.0.1</td>
                                    </tr>
                                    <tr>
                                        <td>{{ now()->subMinutes(18)->format('Y-m-d H:i') }}</td>
                                        <td>查看儀表板</td>
                                        <td>127.0.0.1</td>
                                    </tr>
                                    <tr>
                                        <td>{{ now()->subHour()->format('Y-m-d H:i') }}</td>
                                        <td>系統啟動</td>
                                        <td>local</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                </div>
            </main>
        </section>
    </div>

    <script>
        (function() {
            const $ = (sel, root = document) => root.querySelector(sel);
            const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));

            // toggle submenu
            $$('.item[data-menu]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const key = btn.getAttribute('data-menu');
                    const expanded = btn.getAttribute('aria-expanded') === 'true';
                    btn.setAttribute('aria-expanded', expanded ? 'false' : 'true');
                    const submenu = $(`.submenu[data-submenu="${key}"]`);
                    if (submenu) submenu.classList.toggle('open', !expanded);
                });
            });
        })();
    </script>

</body>

</html>
