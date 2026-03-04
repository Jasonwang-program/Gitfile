{{-- resources/views/admin/news/newsType/add.blade.php --}}

@extends('admin.layout')

@section('content')
    <h2 style="margin:0 0 12px 0;">新增類別</h2>

    {{-- ✅ 錯誤訊息 --}}
    @if ($errors->any())
        <div class="alert alert-danger" style="margin-bottom:12px;">
            <b>新增失敗：</b>
            <ul style="margin:6px 0 0 18px;">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.news.types.store') }}">
        @csrf

        <div style="margin-bottom:12px;">
            <label style="display:block; margin-bottom:6px;">類別名稱</label>
            <input type="text" name="typeName" value="{{ old('typeName') }}" placeholder="例如：公司公告 / 活動消息 / 產品更新"
                style="width:min(520px, 100%); padding:10px 12px; border-radius:12px; border:1px solid rgba(45,85,48,.2);">
        </div>

        <div style="display:flex; gap:10px; align-items:center;">
            <button type="submit" class="btn btn-primary">儲存</button>
            <a class="btn" href="{{ route('admin.news.types.index') }}">返回列表</a>
        </div>
    </form>
@endsection
