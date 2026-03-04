@extends('admin.layout')

@section('content')
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
        <h2 style="margin:0;">最新消息管理</h2>

        {{-- 小超越：新增按鈕 --}}
        <a class="btn btn-primary" href="{{ route('admin.news.create') }}">新增</a>
    </div>

    {{-- 小超越：簡單搜尋（標題） --}}
    <form method="GET" action="{{ route('admin.news.index') }}" style="margin-bottom:12px;">
        <input type="text" name="q" value="{{ $q }}" placeholder="搜尋標題..."
            style="width:240px; padding:6px 8px;">
        <button type="submit" class="btn btn-secondary">搜尋</button>
        @if (!empty($q))
            <a href="{{ route('admin.news.index') }}" style="margin-left:8px;">清除</a>
        @endif
    </form>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width:60px;">ID</th>
                <th style="width:140px;">分類</th>
                <th>標題</th>
                <th style="width:120px;">圖片</th>
                <th style="width:180px;">建立時間</th>
                <th style="width:110px;">操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $r)
                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ $r->typeName ?? '（未分類）' }}</td>
                    <td>{{ $r->title }}</td>
                    <td>{{ $r->photo }}</td>
                    <td>{{ $r->createTime }}</td>
                    <td>
                        {{-- 初學者：用 POST 刪除，避免 DELETE method 的坑 --}}
                        <form method="POST" action="{{ route('admin.news.delete', $r->id) }}"
                            onsubmit="return confirm('確定刪除？');" style="display:inline;">
                            @csrf
                            <button class="btn btn-danger btn-sm">刪除</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">目前沒有資料</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
