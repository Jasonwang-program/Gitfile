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
                        <a class="menu-link" href="/admin/news/type/list">
                            <span class="menu-icon">📂</span>
                            <span>最新消息類別管理</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="/admin/news/list">
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