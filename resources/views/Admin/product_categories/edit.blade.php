@extends('layouts.admin')

@section('adminContent')
    <form method="POST" action="{{ route('admin.product_categories.update', ['product_category' => $productCategory]) }}">
        @method('PUT')
        @include('admin.product_categories._form')
        <hr>
        <a href="{{ route('admin.product_categories.show', ['product_category' => $productCategory]) }}" class="btn btn-secondary me-2">キャンセル</a>
        <button type="submit" class="btn btn-primary">更新</button>
    </form>
@endsection
