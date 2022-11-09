@extends('layouts.admin')

@section('adminContent')
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @include('admin.products._form')
        <hr>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary me-2">キャンセル</a>
        <button type="submit" class="btn btn-primary">作成</button>
    </form>
@endsection
