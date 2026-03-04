{{-- resources/views/admin/news/news/create.blade.php --}}
@extends('admin.layout')

@section('content')
    <h2 style="margin:0 0 12px;">新增最新消息</h2>

    {{-- 顯示驗證錯誤 --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin:0;">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.news.store') }}">
        @csrf

        <div style="margin-bottom:10px;">
            <label>分類</label><br>
            <select name="typeId" style="width:260px; padding:6px;">
                <option value="">請選擇</option>
                @foreach ($types as $t)
                    <option value="{{ $t->id }}" @selected(old('typeId') == $t->id)>{{ $t->typeName }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom:10px;">
            <label>標題</label><br>
            <input type="text" name="title" value="{{ old('title') }}" style="width:520px; padding:6px;"
                maxlength="100">
        </div>

        <div style="margin-bottom:10px;">
            <label>內容</label><br>
            <textarea name="content" rows="6" style="width:520px; padding:6px;">{{ old('content') }}</textarea>
        </div>

        <div style="margin-bottom:10px;">
            <label>圖片（先填檔名即可）</label><br>
            <input type="text" name="photo" value="{{ old('photo') }}" style="width:260px; padding:6px;"
                maxlength="30">
        </div>

        <button class="btn btn-primary">送出</button>
        <a class="btn btn-secondary" href="{{ route('admin.news.index') }}">返回</a>
    </form>
@endsection
