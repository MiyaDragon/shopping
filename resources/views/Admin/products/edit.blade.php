@extends('layouts.admin')

@section('adminContent')
<form method="POST" action="{{ route('admin.products.update', ['product' => $product]) }}" class="mb-5" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @if ($errors->any())
        <div class="alert alert-danger my-3" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="col-12 mt-3">
        <label class="form-label" for="name">商品カテゴリ</label>
        <select class="form-select" name="product_category_id">
            @foreach($productCategories as $productCategory)
                <option value={{ $productCategory->id }} @if($productCategory->id == $product->product_category_id)
                selected @endif>{{ $productCategory->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 mt-3">
        <label class="form-label" for="name">名称</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="名称" value="{{ old('name') ?? $product->name }}">
    </div>
    <div class="col-12 mt-3">
        <label class="form-label" for="price">価格</label>
        <input type="number" class="form-control" id="price" name="price" placeholder="価格" value="{{ old('price') ?? $product->price }}">
    </div>
    <div class="col-12 mt-3">
        <label class="form-label" for="description">説明</label>
        <textarea class="form-control" id="description" rows="2" placeholder="説明" name="description">{{ old('description') ?? $product->description }}</textarea>
    </div>
    <div class="col-12 mt-3">
        <label class="form-label" for="image">イメージ</label>
        <input class="form-control mb-3" type="file" id="image" name="image_path">
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="delete" id="delete" value="true">
            <label class="form-check-label" for="delete">削除</label>
        </div>
        <img src="{{ asset('storage/' . $product->image_path) }}" alt="画像" style="width: 70%;">
    </div>
    <hr>
    <a href="{{ route('admin.products.show', ['product' => $product]) }}" class="btn btn-secondary me-2">キャンセル</a>
    <button type="submit" class="btn btn-primary">更新</button>
</form>
@endsection
