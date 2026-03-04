{{-- resources/views/admin/news/news/create.blade.php --}}
@extends('admin.layout')

@section('content')
    <h2 style="margin:0 0 12px;">新增最新消息</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin:0;">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ✅ 重要：要上傳檔案一定要 enctype --}}
    <form method="POST" action="/admin/news/add" enctype="multipart/form-data">
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
            <label>圖片（可不選）</label><br>
            <input type="file" name="photo" accept="image/*">
            <div style="font-size:12px; opacity:.75; margin-top:4px;">
                圖片會存到：public/images/news/；資料庫只存檔名（Excel 插圖會用這個檔名找檔案）。
            </div>
        </div>

        <button class="btn btn-primary">送出</button>
        <a class="btn btn-secondary" href="/admin/news/list">返回</a>
    </form>
@endsection
