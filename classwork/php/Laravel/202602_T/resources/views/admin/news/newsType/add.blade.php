@extends("admin.layout")
@section("title", "新增最新消息類別")
@section("content")
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-2">
                        <a class="btn btn-secondary" href="list">回上頁</a>
                    </div>
                </div>
            </div>
        </div>
        <form name="list" id="list" method="post" action="add">
            @csrf
            <table class="table table-order border border-dark">
                <tr class="table-warning">
                    <td class="col-2 text-center border border-dark">類別名稱</td>
                    <td class="col-10 text-center border border-dark">
                        <input type="text" name="typeName" class="form-control border border-dark">
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