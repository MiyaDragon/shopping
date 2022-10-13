@extends('layouts.admin')

@section('adminContent')
<div class="col-12 my-3 d-flex gap-2">
    <a href="{{ route('admin.product_categories.index') }}" class="btn btn-white me-2">一覧</a>
    <a href="{{ route('admin.product_categories.edit', ['product_category' => $productCategory]) }}" class="btn btn-success">編集</a>
    <form method="POST" action="{{ route('admin.product_categories.destroy', ['product_category' => $productCategory]) }}">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger">削除</button>
    </form>
</div>

<div class="col-12">
    <table class="table border-top">
        <tbody>
        <tr>
            <th scope="row">ID</th>
            <td>{{ $productCategory->id }}</td>
        </tr>
        <tr>
            <th scope="row">名称</th>
            <td>{{ $productCategory->name }}</td>
        </tr>
        <tr>
            <th scope="row">並び順番号</th>
            <td>{{ $productCategory->order_no }}</td>
        </tr>
        </tbody>
    </table>
</div>
@endsection
