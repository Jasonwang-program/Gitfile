@extends("admin.layout")
@section("title", "後台首頁")
@section("content")
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
        <button class="btn btn-primary">新增最新消息</button>
        <button class="btn btn-primary" style="margin-left: 10px;">新增產品</button>
    </div>
</div>
@endsection