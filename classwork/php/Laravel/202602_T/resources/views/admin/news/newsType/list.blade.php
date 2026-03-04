@extends("admin.layout")
@section("title", "最新消息類別管理")
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
                    <td class="col-10 text-center border border-dark">類別名稱</td>
                    <td class="col-1 text-center border border-dark">修改</td>
                </tr>
                @foreach($typeList as $data)
                    <tr>
                        <td class="text-center border border-dark">
                            <input type="checkbox" class="form-check-input border border-dark child" name="id[]" value="{{ $data->id }}">
                        </td>
                        <td class="text-center border border-dark">{{ $data->typeName }}</td>
                        <td class="text-center border border-dark"><a href="edit/{{ $data->id }}" class="btn btn-success">修改</a></td>
                    </tr>
                @endforeach
            </table>
        </form>
    </div>
</div>

@endsection