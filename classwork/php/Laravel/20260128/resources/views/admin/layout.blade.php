{{-- resources/views/admin/layout.blade.php --}}
<!doctype html>
<html lang="zh-TW">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page_title', '後台管理')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ✅ 提醒：你有放 bootstrap 本機檔，可用 asset 引入 --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap5.2.3.min.css') }}"> --}}

    <style>
        :root {
            --bg: #98d496;
            --panel: rgba(255, 255, 255, .75);
            --panel2: rgba(255, 255, 255, .55);
            --border: rgba(45, 85, 48, .15);
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
            background: rgba(255, 255, 255, .65);
            backdrop-filter: blur(16px);
            padding: 20px 18px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            box-shadow: 10px 0 50px rgba(0, 0, 0, .05);
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

        .pageTitle {
            display: flex;
            flex-direction: column;
            gap: 2px;
            min-width: 0;
        }

        .pageTitle b {
            font-size: 16px;
            letter-spacing: .2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pageTitle span {
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

        .panel {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            background: var(--panel);
            backdrop-filter: blur(14px);
            box-shadow: var(--shadow);
            padding: 24px;
            min-height: 100%;
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
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn:hover {
            transform: translateY(-1px);
            border-color: var(--brand);
            box-shadow: 0 0 0 4px var(--ring);
        }

        .btn.danger:hover {
            border-color: var(--danger);
            box-shadow: 0 0 0 4px rgba(220, 38, 38, .1);
        }

        .muted {
            color: var(--muted)
        }

        .grid {
            display: grid;
            gap: 14px
        }

        .grid.cols4 {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .grid.cols2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        @media(max-width:1100px) {
            .grid.cols4 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media(max-width:720px) {

            .grid.cols4,
            .grid.cols2 {
                grid-template-columns: 1fr;
            }
        }

        .card {
            border: 1px solid var(--border);
            border-radius: var(--radius2);
            background: rgba(255, 255, 255, .7);
            padding: 16px;
        }

        .card b {
            display: block;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .card .big {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: .3px;
        }

        .hr {
            height: 1px;
            background: rgba(45, 85, 48, .12);
            margin: 14px 0;
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
        <aside class="sidebar">
            @include('admin.menu')
        </aside>

        <section class="main">
            <header class="topbar">
                <div class="pageTitle">
                    <b>@yield('header_title', '儀表板')</b>
                    <span>@yield('header_desc', '後台總覽、快捷入口與系統狀態')</span>
                </div>
                <div class="topbarRight">
                    <div class="pill"><span class="dot"></span> 系統正常</div>
                    <div class="pill">ENV：<b>{{ app()->environment() }}</b></div>

                    {{-- ✅ 登出（必須 POST） --}}
                    <form action="{{ route('admin.logout') }}" method="POST" style="margin:0;">
                        @csrf
                        <button class="btn danger" type="submit">登出</button>
                    </form>
                </div>
            </header>

            <main class="content">
                <div class="panel">
                    @yield('content')
                </div>
            </main>
        </section>
    </div>

    @stack('scripts')
</body>

</html>
