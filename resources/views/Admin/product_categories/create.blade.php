@extends('layouts.admin')

@section('adminContent')
    <form method="POST" action="{{ route('admin.product_categories.store') }}">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger my-3" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col-12 my-3">
            <label class="form-label" for="name">名称</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="名称" value="{{ old('name') }}">
        </div>
        <div class="col-12">
            <label class="form-label" for="order_no">並び順番号</label>
            <input type="number" class="form-control" id="order_no" name="order_no" placeholder="並び順番号" value="{{ old('order_no') }}">
        </div>
        <hr>
        <a href="{{ route('admin.product_categories.index') }}" class="btn btn-secondary me-2">キャンセル</a>
        <button type="submit" class="btn btn-primary">作成</button>
    </form>
@endsection
