@extends("admin.layout")
@section("title", "修改最新消息")
@section("content")
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-2">
                        <a class="btn btn-secondary" href="../list">回上頁</a>
                    </div>
                </div>
            </div>
        </div>
        <form name="list" id="list" method="post" action="../add" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $news->id }}">
            <table class="table table-order border border-dark">
                <tr class="table-warning">
                    <td class="col-2 text-center border border-dark">類別</td>
                    <td class="col-10 text-center border border-dark">
                        <select name="typeId" required class="form-control">
                            <option value="">請選擇</option>
                            @foreach($list as $data)
                            <option value="{{ $data->id }}" {{ $news->typeId == $data->id ? " selected" : "" }}>{{ $data->typeName }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr class="table-warning">
                    <td class="col-2 text-center border border-dark">標題</td>
                    <td class="col-10 text-center border border-dark">
                        <input type="text" class="form-control" name="title" required value="{{ $news->title }}">
                    </td>
                </tr>
                <tr class="table-warning">
                    <td class="col-2 text-center border border-dark">內容</td>
                    <td class="col-10 text-center border border-dark">
                        <textarea class="form-control" rows="5" name="content" required>{{ str_replace("<br/>", "\n", $news->content) }}</textarea>
                    </td>
                </tr>
                <tr class="table-warning">
                    <td class="col-2 text-center border border-dark">圖檔</td>
                    <td class="col-10 border border-dark">
                        <input type="file" class="form-control" name="photo">
                        @if (!empty($news->photo))
                        <div class="mt-3">
                            <a href="/images/news/{{ $news->photo }}" data-lightbox="photo" data-title="{{ $news->title }}">
                                <img src="/images/news/{{ $news->photo }}" width="100">
                            </a>
                        </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="text-center border border-dark" colspan="2">
                        <input type="submit" value=" 確 定 " class="btn btn-primary btn-lg">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

@endsection