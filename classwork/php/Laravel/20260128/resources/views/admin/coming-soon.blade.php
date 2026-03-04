{{-- resources/views/admin/coming-soon.blade.php --}}
@extends('admin.layout')

@section('page_title', '功能施工中')
@section('header_title', $title ?? '功能施工中')
@section('header_desc', '此頁先做路由與版面接通，後續再接上 CRUD')

@section('content')
    <div class="card">
        <b>✅ 已接通：路由 / 選單 / 登入保護</b>
        <div class="muted" style="margin-top:8px;">
            {{ $desc ?? '此功能頁面尚未完成，先提供可用入口避免 404。' }}
        </div>

        <div class="hr"></div>

        <div class="muted">
            接下來你想先做哪一個 CRUD？
            <br>① 最新消息管理（文章）
            <br>② 關於我們（公司簡介/里程碑）
            <br>③ 產品介紹（分類/產品/圖片）
        </div>

        <div class="hr"></div>

        <a class="btn" href="{{ route('admin.index') }}">回儀表板</a>
    </div>
@endsection
