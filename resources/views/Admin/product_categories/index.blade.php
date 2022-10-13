@extends('layouts.admin')

@section('adminContent')
<div class="card shadow border-0 my-3 py-4 px-3">
    <form method="GET" action="{{ route('admin.product_categories.index') }}" class="row g-3">
        <div class="col-12">
            <input type="text" class="form-control" name="keyword" placeholder="名称"
                   value="@if((!empty(Request::get('keyword')))) {{ Request::get('keyword') }} @endif">
        </div>
        <div class="col-4">
            <select class="form-select" name="element">
                @foreach(config('product_categories.element') as $key => $value)
                    <option value={{ $key }} @if((!empty(Request::get('element')) && Request::get('element') == $key))
                        selected @endif>{{ "並び替え：" . $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4">
            <select class="form-select" name="direction">
                @foreach(config('product_categories.direction') as $key => $value)
                    <option value={{ $key }} @if((!empty(Request::get('direction')) && Request::get('direction') == $key))
                    selected @endif>{{ "並び替え方向：" . $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-2">
            <select class="form-select" name="count">
                @foreach(config('product_categories.count') as $value)
                    <option value={{ $value }} @if((!empty(Request::get('count')) && Request::get('count') == $value))
                    selected @endif>{{ "表示：" . $value . "件" }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-2">
            <button type="submit" class="btn btn-primary">検索</button>
        </div>
    </form>
</div>
<div class="col-12">
    <a href="{{ route('admin.product_categories.create') }}" class="btn btn-success">新規</a>
</div>
<div class="col-12 my-3">
    <table class="table table-striped border-top">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">名称</th>
            <th scope="col">並び順番号</th>
        </tr>
        </thead>
        <tbody>
            @foreach($productCategories as $productCategory)
                <tr>
                    <th scope="row">{{ $productCategory->id }}</th>
                    <td>
                        <a href="{{ route('admin.product_categories.show', ['product_category' => $productCategory]) }}">
                            {{ $productCategory->name }}
                        </a>
                    </td>
                    <td>{{ $productCategory->order_no }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $productCategories->links() }}
@endsection
