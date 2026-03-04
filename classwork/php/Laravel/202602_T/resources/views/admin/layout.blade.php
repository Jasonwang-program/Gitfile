<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>後台管理系統</title>
    <link href="/css/bootstrap5.2.3.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.20/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.20/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-4.0.0.min.js"></script>
    <link href="/css/lightbox.min.css" rel="stylesheet">
    <script src="/js/lightbox.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Microsoft JhengHei', 'PingFang TC', sans-serif;
            background: #f5f7fa;
            height: 100vh;
            overflow: hidden;
        }

        .container2 {
            display: flex;
            height: 100vh;
        }

        /* 左側選單樣式 */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            color: white;
            overflow-y: auto;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 25px 20px;
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h2 {
            font-size: 20px;
            font-weight: 600;
            color: #ecf0f1;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-header h2::before {
            content: "⚙️";
            font-size: 24px;
        }

        .menu {
            padding: 15px 0;
        }

        .menu-item {
            list-style: none;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: #ecf0f1;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            font-size: 15px;
        }

        .menu-link:hover {
            background: rgba(52, 152, 219, 0.2);
            border-left: 4px solid #3498db;
            padding-left: 16px;
        }

        .menu-link.active {
            background: rgba(254, 254, 254, 0.3);
            border-left: 4px solid #3498db;
            padding-left: 16px;
        }

        .menu-icon {
            margin-right: 12px;
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .expand-icon {
            margin-left: auto;
            font-size: 12px;
            transition: transform 0.3s ease;
        }

        .expand-icon.expanded {
            transform: rotate(90deg);
        }

        .submenu {
            display: none;
            background: rgba(0, 0, 0, 0.15);
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.3s ease;
        }

        .submenu.show {
            display: block;
            max-height: 200px;
        }

        .submenu .menu-link {
            /*padding-left: 55px;*/
            font-size: 14px;
        }

        /*
        .submenu .menu-link:hover {
            padding-left: 51px;
        }

        .submenu .menu-link.active {
            padding-left: 51px;
        }*/

        /* 右側內容區域 */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* 標題區 */
        .header {
            background: white;
            padding: 20px 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #3498db;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-title h1 {
            font-size: 24px;
            color: #2c3e50;
            font-weight: 600;
        }

        .breadcrumb {
            font-size: 14px;
            color: #7f8c8d;
        }

        .breadcrumb span {
            margin: 0 5px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* 內容區 */
        .content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            background: #f5f7fa;
        }

        .content-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .content-card h2 {
            color: #2c3e50;
            font-size: 20px;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #ecf0f1;
        }

        .content-card p {
            color: #5a6c7d;
            line-height: 1.8;
            font-size: 15px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .stat-card h3 {
            font-size: 14px;
            font-weight: 500;
            opacity: 0.9;
            margin-bottom: 8px;
        }

        .stat-card .number {
            font-size: 32px;
            font-weight: 700;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
        }

        /* 滾動條樣式 */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #bdc3c7;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #95a5a6;
        }
    </style>
    <script>
        $(function() {
            // 全選的checkbox的狀態有變更時(未選取-->選取, 選取-->未選取)
            $("#all").on("change", function() {
                // child:子項目 prop:屬性 checked:選取
                $(".child").prop("checked", $(this).prop("checked"));
            });
        });

        function deleteAll(form) {
            Swal.fire({
                title: "確定刪除?",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "確定",
                denyButtonText: "放棄"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.forms[form].submit();
                }
            });
        }
    </script>
</head>

<body>
    @if(Session::has("message"))
    <script>
        Swal.fire("{{ Session::get('message') }}");
    </script>
    @endif
    <div class="container2">
        <!-- 左側選單 -->
        @include("admin.menu")

        <!-- 右側內容區 -->
        <main class="main-content">
            <!-- 標題區 -->
            <header class="header">
                <div class="header-title">
                    <h1 id="page-title">@yield("title")</h1>
                </div>
                <div class="user-info">
                    <div class="breadcrumb">
                        <span id="breadcrumb">首頁</span>
                    </div>
                    <div class="user-avatar">{{ session()->get("managerId") }}</div>
                </div>
            </header>

            <!-- 內容區 -->
            <section class="content" id="content-area">
                @yield("content")
            </section>
        </main>
    </div>

    <script>
        // 切換子選單
        function toggleSubmenu(element) {
            const submenu = element.nextElementSibling;
            const expandIcon = element.querySelector('.expand-icon');
            
            if (submenu && submenu.classList.contains('submenu')) {
                submenu.classList.toggle('show');
                expandIcon.classList.toggle('expanded');
            }
        }
    </script>
</body>

</html>