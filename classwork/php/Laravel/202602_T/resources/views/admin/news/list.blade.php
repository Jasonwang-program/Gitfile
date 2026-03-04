@extends("admin.layout")
@section("title", "最新消息管理")
@section("content")
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-2">
                        <a class="btn btn-primary" href="add">新增</a>
                    </div>
                    <div class="col-2">
                        <a class="btn btn-danger" href="javascript:deleteAll('list')">刪除</a>
                    </div>
                </div>
            </div>
        </div>
        <form name="list" id="list" method="post" action="delete">
            @csrf
            <table class="table table-order border border-dark">
                <tr class="table-warning">
                    <td class="col-1 text-center border border-dark">
                        <input type="checkbox" class="form-check-input border border-dark" id="all">
                    </td>
                    <td class="col-1 text-center border border-dark">類別名稱</td>
                    <td class="col-2 text-center border border-dark">標題</td>
                    <td class="col-3 text-center border border-dark">內容</td>
                    <td class="col-2 text-center border border-dark">圖檔</td>
                    <td class="col-2 text-center border border-dark">建立時間</td>
                    <td class="col-1 text-center border border-dark">修改</td>
                </tr>
                @foreach($list as $data)
                <tr>
                    <td class="text-center border border-dark align-middle">
                        <input type="checkbox" class="form-check-input border border-dark child" name="id[]" value="{{ $data->id }}">
                    </td>
                    <td class="text-center border border-dark align-middle">{{ $data->typeName }}</td>
                    <td class="text-center border border-dark align-middle">{{ $data->title }}</td>
                    <td class="text-center border border-dark align-middle">{!! $data->content !!}</td>
                    <td class="text-center border border-dark align-middle">
                        @if (!empty($data->photo))
                        <a href="/images/news/{{ $data->photo }}" data-lightbox="photo" data-title="{{ $data->title }}">
                            <img src="/images/news/{{ $data->photo }}" width="100">
                        </a>
                        @endif
                    </td>
                    <td class="text-center border border-dark align-middle">{{ $data->createTime }}</td>
                    <td class="text-center border border-dark align-middle"><a href="edit/{{ $data->id }}" class="btn btn-success">修改</a></td>
                </tr>
                @endforeach
            </table>
        </form>
    </div>
</div>

@endsection