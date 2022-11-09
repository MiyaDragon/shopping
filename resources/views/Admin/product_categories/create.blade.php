@extends('layouts.admin')

@section('adminContent')
    <form method="POST" action="{{ route('admin.product_categories.store') }}">
        @include('admin.product_categories._form')
        <hr>
        <a href="{{ route('admin.product_categories.index') }}" class="btn btn-secondary me-2">キャンセル</a>
        <button type="submit" class="btn btn-primary">作成</button>
    </form>
@endsection
