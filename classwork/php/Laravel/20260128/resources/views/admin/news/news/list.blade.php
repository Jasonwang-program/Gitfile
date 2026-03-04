@extends('admin.layout')

@section('content')
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
        <h2 style="margin:0;">最新消息管理</h2>

        <div style="display:flex; gap:8px;">
            <a class="btn btn-secondary" href="/admin/news/export">匯出 Excel</a>
            <a class="btn btn-primary" href="/admin/news/add">新增</a>
        </div>
    </div>

    {{-- 搜尋（標題） --}}
    <form method="GET" action="/admin/news/list" style="margin-bottom:12px;">
        <input type="text" name="q" value="{{ $q }}" placeholder="搜尋標題..."
            style="width:240px; padding:6px 8px;">
        <button type="submit" class="btn btn-secondary">搜尋</button>
        @if (!empty($q))
            <a href="/admin/news/list" style="margin-left:8px;">清除</a>
        @endif
    </form>

    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    {{-- ✅ 批次刪除：checkbox name="id[]" 對應 Controller delete() --}}
    <form method="POST" action="/admin/news/delete" onsubmit="return confirm('確定刪除勾選的資料？');">
        @csrf

        <div style="margin-bottom:10px;">
            <button class="btn btn-danger" type="submit">刪除（勾選）</button>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width:40px; text-align:center;">
                        <input type="checkbox" id="all">
                    </th>
                    <th style="width:80px;">ID</th>
                    <th style="width:140px;">分類</th>
                    <th>標題</th>
                    <th style="width:140px;">圖片</th>
                    <th style="width:180px;">建立時間</th>
                    <th style="width:90px;">修改</th>
                </tr>
            </thead>

            <tbody>
                @forelse($rows as $r)
                    <tr>
                        <td style="text-align:center;">
                            <input type="checkbox" class="child" name="id[]" value="{{ $r->id }}">
                        </td>
                        <td>{{ $r->id }}</td>
                        <td>{{ $r->typeName ?? '（未分類）' }}</td>
                        <td>{{ $r->title }}</td>

                        <td>
                            @if (!empty($r->photo) && is_file(public_path('images/news/' . $r->photo)))
                                <img src="{{ asset('images/news/' . $r->photo) }}"
                                    style="max-width:120px; max-height:80px; object-fit:cover;">
                            @else
                                <span style="opacity:.65;">（無）</span>
                            @endif
                        </td>

                        <td>{{ $r->createTime }}</td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="/admin/news/edit/{{ $r->id }}">編輯</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">目前沒有資料</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </form>

    {{-- ✅ 全選 JS --}}
    <script>
        (function() {
            const all = document.getElementById('all');
            if (!all) return;

            all.addEventListener('change', function() {
                document.querySelectorAll('input.child').forEach(chk => chk.checked = all.checked);
            });
        })();
    </script>
@endsection
