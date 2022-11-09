@extends('layouts.admin')

@section('adminContent')
    <div class="col-12 my-3 d-flex gap-2">
        <a href="{{ route('admin.products.index') }}" class="btn btn-white me-2">一覧</a>
        <a href="{{ route('admin.products.edit', ['product' => $product]) }}" class="btn btn-success">編集</a>
        <form method="POST" action="{{ route('admin.products.destroy', ['product' => $product]) }}">
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
                <td>{{ $product->id }}</td>
            </tr>
            <tr>
                <th scope="row">商品カテゴリ</th>
                <td>{{ $product->productCategory->name }}</td>
            </tr>
            <tr>
                <th scope="row">名称</th>
                <td>{{ $product->name }}</td>
            </tr>
            <tr>
                <th scope="row">価格</th>
                <td>{{ "¥" . number_format($product->price) }}</td>
            </tr>
            <tr>
                <th scope="row">説明</th>
                <td>{!! nl2br(e($product->description)) !!}</td>
            </tr>
            <tr>
                <th scope="row">イメージ</th>
                <td>
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="画像">
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
