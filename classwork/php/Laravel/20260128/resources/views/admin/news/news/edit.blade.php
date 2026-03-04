{{-- resources/views/admin/news/news/edit.blade.php --}}
@extends('admin.layout')

@section('content')
    <h2 style="margin:0 0 12px;">編輯最新消息</h2>

    @if (!$news)
        <div class="alert alert-danger">找不到資料</div>
        <a class="btn btn-secondary" href="/admin/news/list">返回</a>
        @return
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin:0;">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        // ✅ DB 存 <br/>，編輯時還原成 \n
        $contentForTextarea = str_ireplace(['<br />', '<br/>', '<br>'], "\n", $news->content ?? '');
    @endphp

    <form method="POST" action="/admin/news/edit" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="id" value="{{ $news->id }}">
        <input type="hidden" name="photo_old" value="{{ $news->photo ?? '' }}">

        <div style="margin-bottom:10px;">
            <label>分類</label><br>
            <select name="typeId" style="width:260px; padding:6px;">
                <option value="">請選擇</option>
                @foreach ($types as $t)
                    <option value="{{ $t->id }}" @selected(old('typeId', $news->typeId) == $t->id)>{{ $t->typeName }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom:10px;">
            <label>標題</label><br>
            <input type="text" name="title" value="{{ old('title', $news->title) }}" style="width:520px; padding:6px;"
                maxlength="100">
        </div>

        <div style="margin-bottom:10px;">
            <label>內容</label><br>
            <textarea name="content" rows="6" style="width:520px; padding:6px;">{{ old('content', $contentForTextarea) }}</textarea>
            <div style="font-size:12px; opacity:.75; margin-top:4px;">
                這裡會把資料庫內的 &lt;br/&gt; 還原成換行方便編輯；送出更新時會再轉回 &lt;br/&gt; 存回資料庫。
            </div>
        </div>

        <div style="margin-bottom:10px;">
            <label>目前圖片</label><br>
            @if (!empty($news->photo) && is_file(public_path('images/news/' . $news->photo)))
                <div style="margin:6px 0;">
                    <img src="{{ asset('images/news/' . $news->photo) }}"
                        style="max-width:320px; max-height:200px; object-fit:cover; border:1px solid #ddd; border-radius:8px;">
                </div>
                <div style="font-size:12px; opacity:.75;">
                    目前檔名：<code>{{ $news->photo }}</code>
                </div>
            @else
                <div style="opacity:.65;">（目前無圖片）</div>
            @endif
        </div>

        <div style="margin-bottom:12px;">
            <label>更換圖片（可不選）</label><br>
            <input type="file" name="photo" accept="image/*">
            <div style="font-size:12px; opacity:.75; margin-top:4px;">
                若未選新圖片，會保留舊圖片；若選了新圖片，會上傳到 public/images/news 並更新 DB 的 photo（只存檔名）。
            </div>
        </div>

        <button class="btn btn-primary">儲存</button>
        <a class="btn btn-secondary" href="/admin/news/list">返回</a>
    </form>
@endsection
