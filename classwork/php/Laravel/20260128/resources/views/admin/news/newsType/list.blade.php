{{-- resources/views/admin/news/newsType/list.blade.php --}}

@extends('admin.layout')

@section('content')
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
        <h2 style="margin:0;">最新消息管理類別</h2>

        {{-- ✅ 新增 --}}
        <a class="btn btn-primary" href="{{ route('admin.news.types.create') }}">新增</a>
    </div>

    {{-- ✅ 搜尋：GET q --}}
    <form method="GET" action="{{ route('admin.news.types.index') }}" style="margin-bottom:12px;">
        <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="搜尋類別名稱..."
            style="width:240px; padding:6px 8px;">
        <button type="submit" class="btn btn-secondary">搜尋</button>

        @if (!empty($q ?? ''))
            <a href="{{ route('admin.news.types.index') }}" style="margin-left:8px;">清除</a>
        @endif
    </form>

    {{-- ✅ 成功訊息 --}}
    @if (session('success'))
        <div class="alert alert-success" style="margin-bottom:12px;">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width:80px;">ID</th>
                <th>類別名稱</th>
                <th style="width:180px;">操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse($typeList as $row)
                <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->typeName }}</td>
                    <td style="display:flex; gap:8px; align-items:center;">
                        {{-- ✅ 編輯 --}}
                        <a class="btn btn-sm btn-secondary" href="{{ route('admin.news.types.edit', ['id' => $row->id]) }}">
                            編輯
                        </a>

                        {{-- ✅ 刪除：初學者先用 POST --}}
                        <form method="POST" action="{{ route('admin.news.types.delete', ['id' => $row->id]) }}"
                            onsubmit="return confirm('確定刪除？刪除後無法復原');" style="margin:0;">
                            @csrf
                            <button type="submit" class="btn btn-sm danger">刪除</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">目前沒有資料</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ✅ 小提醒（初學者友善） --}}
    <div style="margin-top:12px; color:#4b634d; font-size:13px;">
        注意：如果你點「新增/編輯」出現 500，通常是 <code>news_types</code> 資料表或欄位尚未建立/不一致。
    </div>
@endsection
