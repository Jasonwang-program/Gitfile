<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>後台管理系統</title>
    
    <!-- Bootstrap 5.2.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
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

        .admin-container {
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
            background: rgba(52, 152, 219, 0.3);
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
            padding-left: 55px;
            font-size: 14px;
        }

        .submenu .menu-link:hover {
            padding-left: 51px;
        }

        .submenu .menu-link.active {
            padding-left: 51px;
        }

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

        .custom-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .custom-btn-primary {
            background: #3498db;
            color: white;
        }

        .custom-btn-primary:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
        }
        
        .custom-btn-warning {
            background: #f39c12;
            color: white;
        }
        
        .custom-btn-danger {
            background: #e74c3c;
            color: white;
        }
        
        .custom-btn-info {
            background: #3498db;
            color: white;
        }
        
        .custom-btn-sm {
            padding: 6px 12px;
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
</head>
<body>
    <div class="admin-container">
        <!-- 左側選單 -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>管理系統</h2>
            </div>
            <nav class="menu">
                <ul>
                    <!-- 最新消息 (可展開) -->
                    <li class="menu-item">
                        <a class="menu-link" onclick="toggleSubmenu(this)">
                            <span class="menu-icon">📰</span>
                            <span>最新消息</span>
                            <span class="expand-icon">▶</span>
                        </a>
                        <ul class="submenu">
                            <li class="menu-item">
                                <a class="menu-link" onclick="loadContent('news-category', this)">
                                    <span class="menu-icon">📂</span>
                                    <span>最新消息類別管理</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="menu-link" onclick="loadContent('news-management', this)">
                                    <span class="menu-icon">📝</span>
                                    <span>最新消息管理</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- 關於我們 -->
                    <li class="menu-item">
                        <a class="menu-link" onclick="loadContent('about', this)">
                            <span class="menu-icon">ℹ️</span>
                            <span>關於我們</span>
                        </a>
                    </li>

                    <!-- 產品介紹 -->
                    <li class="menu-item">
                        <a class="menu-link" onclick="loadContent('products', this)">
                            <span class="menu-icon">📦</span>
                            <span>產品介紹</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- 右側內容區 -->
        <main class="main-content">
            <!-- 標題區 -->
            <header class="header">
                <div class="header-title">
                    <h1 id="page-title">歡迎使用後台管理系統</h1>
                </div>
                <div class="user-info">
                    <div class="breadcrumb">
                        <span id="breadcrumb">首頁</span>
                    </div>
                    <div class="user-avatar">Admin</div>
                </div>
            </header>

            <!-- 內容區 -->
            <section class="content" id="content-area">
                <div class="content-card">
                    <h2>系統概覽</h2>
                    <p>歡迎使用後台管理系統！請從左側選單選擇要管理的項目。</p>
                    
                    <div class="stats-grid">
                        <div class="stat-card">
                            <h3>最新消息總數</h3>
                            <div class="number">128</div>
                        </div>
                        <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <h3>產品數量</h3>
                            <div class="number">45</div>
                        </div>
                        <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <h3>本月訪客</h3>
                            <div class="number">2,341</div>
                        </div>
                    </div>
                </div>

                <div class="content-card">
                    <h2>快速操作</h2>
                    <p>您可以從這裡快速執行常用操作。</p>
                    <div style="margin-top: 15px;">
                        <button class="custom-btn custom-btn-primary">新增最新消息</button>
                        <button class="custom-btn custom-btn-primary" style="margin-left: 10px;">新增產品</button>
                    </div>
                </div>
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

        // 載入內容
        function loadContent(type, element) {
            // 移除所有 active 狀態
            document.querySelectorAll('.menu-link').forEach(link => {
                link.classList.remove('active');
            });
            
            // 設定當前選項為 active
            element.classList.add('active');
            
            const contentArea = document.getElementById('content-area');
            const pageTitle = document.getElementById('page-title');
            const breadcrumb = document.getElementById('breadcrumb');
            
            let content = '';
            let title = '';
            let bread = '';
            
            switch(type) {
                case 'news-category':
                    title = '最新消息類別管理';
                    bread = '首頁 > 最新消息 > 類別管理';
                    content = `
                        <div class="content-card">
                            <h2>最新消息類別管理</h2>
                            <p>在這裡您可以管理所有最新消息的類別，包括新增、編輯和刪除類別。</p>
                            <div style="margin-top: 20px;">
                                <button class="custom-btn custom-btn-primary">+ 新增類別</button>
                            </div>
                            <div style="margin-top: 25px; background: #f8f9fa; padding: 20px; border-radius: 8px;">
                                <div style="display: flex; justify-content: space-between; padding: 12px; background: white; margin-bottom: 10px; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                    <span><strong>公司公告</strong></span>
                                    <div>
                                        <button class="custom-btn custom-btn-warning custom-btn-sm" style="margin-right: 5px;">編輯</button>
                                        <button class="custom-btn custom-btn-danger custom-btn-sm">刪除</button>
                                    </div>
                                </div>
                                <div style="display: flex; justify-content: space-between; padding: 12px; background: white; margin-bottom: 10px; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                    <span><strong>活動訊息</strong></span>
                                    <div>
                                        <button class="custom-btn custom-btn-warning custom-btn-sm" style="margin-right: 5px;">編輯</button>
                                        <button class="custom-btn custom-btn-danger custom-btn-sm">刪除</button>
                                    </div>
                                </div>
                                <div style="display: flex; justify-content: space-between; padding: 12px; background: white; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                    <span><strong>產業新聞</strong></span>
                                    <div>
                                        <button class="custom-btn custom-btn-warning custom-btn-sm" style="margin-right: 5px;">編輯</button>
                                        <button class="custom-btn custom-btn-danger custom-btn-sm">刪除</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    break;
                    
                case 'news-management':
                    title = '最新消息管理';
                    bread = '首頁 > 最新消息 > 消息管理';
                    content = `
                        <div class="content-card">
                            <h2>最新消息管理</h2>
                            <p>管理所有最新消息內容，包括發布、編輯和刪除消息。</p>
                            <div style="margin-top: 20px;">
                                <button class="custom-btn custom-btn-primary">+ 發布新消息</button>
                            </div>
                            <div style="margin-top: 25px; background: #f8f9fa; padding: 20px; border-radius: 8px;">
                                <table style="width: 100%; background: white; border-radius: 6px; overflow: hidden;">
                                    <thead>
                                        <tr style="background: #34495e; color: white;">
                                            <th style="padding: 12px; text-align: left;">標題</th>
                                            <th style="padding: 12px; text-align: left;">類別</th>
                                            <th style="padding: 12px; text-align: left;">發布日期</th>
                                            <th style="padding: 12px; text-align: center;">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="border-bottom: 1px solid #ecf0f1;">
                                            <td style="padding: 12px;">2024年度公司尾牙活動通知</td>
                                            <td style="padding: 12px;">公司公告</td>
                                            <td style="padding: 12px;">2024-01-15</td>
                                            <td style="padding: 12px; text-align: center;">
                                                <button class="custom-btn custom-btn-info custom-btn-sm" style="margin-right: 5px;">查看</button>
                                                <button class="custom-btn custom-btn-warning custom-btn-sm" style="margin-right: 5px;">編輯</button>
                                                <button class="custom-btn custom-btn-danger custom-btn-sm">刪除</button>
                                            </td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid #ecf0f1;">
                                            <td style="padding: 12px;">春節假期公告</td>
                                            <td style="padding: 12px;">公司公告</td>
                                            <td style="padding: 12px;">2024-01-20</td>
                                            <td style="padding: 12px; text-align: center;">
                                                <button class="custom-btn custom-btn-info custom-btn-sm" style="margin-right: 5px;">查看</button>
                                                <button class="custom-btn custom-btn-warning custom-btn-sm" style="margin-right: 5px;">編輯</button>
                                                <button class="custom-btn custom-btn-danger custom-btn-sm">刪除</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 12px;">新產品發布會</td>
                                            <td style="padding: 12px;">活動訊息</td>
                                            <td style="padding: 12px;">2024-01-25</td>
                                            <td style="padding: 12px; text-align: center;">
                                                <button class="custom-btn custom-btn-info custom-btn-sm" style="margin-right: 5px;">查看</button>
                                                <button class="custom-btn custom-btn-warning custom-btn-sm" style="margin-right: 5px;">編輯</button>
                                                <button class="custom-btn custom-btn-danger custom-btn-sm">刪除</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `;
                    break;
                    
                case 'about':
                    title = '關於我們';
                    bread = '首頁 > 關於我們';
                    content = `
                        <div class="content-card">
                            <h2>關於我們頁面管理</h2>
                            <p>編輯和管理公司的「關於我們」頁面內容。</p>
                            <div style="margin-top: 25px;">
                                <div style="margin-bottom: 20px;">
                                    <label style="display: block; margin-bottom: 8px; color: #2c3e50; font-weight: 600;">公司名稱</label>
                                    <input type="text" value="範例科技股份有限公司" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                                </div>
                                <div style="margin-bottom: 20px;">
                                    <label style="display: block; margin-bottom: 8px; color: #2c3e50; font-weight: 600;">公司簡介</label>
                                    <textarea rows="6" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; resize: vertical;">我們是一家專注於創新科技的公司，致力於為客戶提供最優質的產品和服務...</textarea>
                                </div>
                                <div style="margin-bottom: 20px;">
                                    <label style="display: block; margin-bottom: 8px; color: #2c3e50; font-weight: 600;">公司願景</label>
                                    <textarea rows="4" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; resize: vertical;">成為業界領先的科技創新企業...</textarea>
                                </div>
                                <button class="custom-btn custom-btn-primary">儲存變更</button>
                            </div>
                        </div>
                    `;
                    break;
                    
                case 'products':
                    title = '產品介紹';
                    bread = '首頁 > 產品介紹';
                    content = `
                        <div class="content-card">
                            <h2>產品管理</h2>
                            <p>管理所有產品資訊，包括新增、編輯和刪除產品。</p>
                            <div style="margin-top: 20px;">
                                <button class="custom-btn custom-btn-primary">+ 新增產品</button>
                            </div>
                            <div style="margin-top: 25px; display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
                                <div style="background: white; border: 1px solid #ecf0f1; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                    <div style="height: 180px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                                    <div style="padding: 15px;">
                                        <h3 style="color: #2c3e50; margin-bottom: 8px;">產品 A</h3>
                                        <p style="color: #7f8c8d; font-size: 14px; margin-bottom: 15px;">這是產品 A 的簡短描述...</p>
                                        <div>
                                            <button class="custom-btn custom-btn-info custom-btn-sm" style="margin-right: 5px;">查看</button>
                                            <button class="custom-btn custom-btn-warning custom-btn-sm" style="margin-right: 5px;">編輯</button>
                                            <button class="custom-btn custom-btn-danger custom-btn-sm">刪除</button>
                                        </div>
                                    </div>
                                </div>
                                <div style="background: white; border: 1px solid #ecf0f1; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                    <div style="height: 180px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);"></div>
                                    <div style="padding: 15px;">
                                        <h3 style="color: #2c3e50; margin-bottom: 8px;">產品 B</h3>
                                        <p style="color: #7f8c8d; font-size: 14px; margin-bottom: 15px;">這是產品 B 的簡短描述...</p>
                                        <div>
                                            <button class="custom-btn custom-btn-info custom-btn-sm" style="margin-right: 5px;">查看</button>
                                            <button class="custom-btn custom-btn-warning custom-btn-sm" style="margin-right: 5px;">編輯</button>
                                            <button class="custom-btn custom-btn-danger custom-btn-sm">刪除</button>
                                        </div>
                                    </div>
                                </div>
                                <div style="background: white; border: 1px solid #ecf0f1; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                    <div style="height: 180px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);"></div>
                                    <div style="padding: 15px;">
                                        <h3 style="color: #2c3e50; margin-bottom: 8px;">產品 C</h3>
                                        <p style="color: #7f8c8d; font-size: 14px; margin-bottom: 15px;">這是產品 C 的簡短描述...</p>
                                        <div>
                                            <button class="custom-btn custom-btn-info custom-btn-sm" style="margin-right: 5px;">查看</button>
                                            <button class="custom-btn custom-btn-warning custom-btn-sm" style="margin-right: 5px;">編輯</button>
                                            <button class="custom-btn custom-btn-danger custom-btn-sm">刪除</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    break;
            }
            
            pageTitle.textContent = title;
            breadcrumb.textContent = bread;
            contentArea.innerHTML = content;
        }
    </script>
    
    <!-- Bootstrap 5.2.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>