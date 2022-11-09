@extends('layouts.admin')

@section('adminContent')
<form method="POST" action="{{ route('admin.products.update', ['product' => $product]) }}" class="mb-5" enctype="multipart/form-data">
    @method('PUT')
    @include('admin.products._form')
    <div class="col-12 mt-3">
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="delete" id="delete" value="true">
            <label class="form-check-label" for="delete">削除</label>
        </div>
        <img src="{{ asset('storage/' . $product->image_path) }}" alt="画像">
    </div>
    <hr>
    <a href="{{ route('admin.products.show', ['product' => $product]) }}" class="btn btn-secondary me-2">キャンセル</a>
    <button type="submit" class="btn btn-primary">更新</button>
</form>
@endsection
