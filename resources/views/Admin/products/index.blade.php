@extends('layouts.admin')

@section('adminContent')
<div class="card shadow border-0 my-3 py-4 px-3">
    <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3">
        <div class="col-4">
            <select class="form-select" name="category">
                <option value="all">すべてのカテゴリー</option>
                @foreach($productCategories as $productCategory)
                    <option value={{ $productCategory->id }} @if(request('category') == $productCategory->id))
                    selected @endif>{{ $productCategory->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-8">
            <input type="text" class="form-control" name="keyword" placeholder="名称"
                   value="{{ Request::get('keyword') }}">
        </div>
        <div class="col-12 input-group">
            <input type="number" class="form-control" name="price" placeholder="価格"
                   value="{{ Request::get('price') }}">
            <div class="input-group-text">
                <input class="form-check-input mt-0" id="over" name="aboveBelow" type="radio" value="over" checked>
                <label class="ms-1 me-2" for="over">以上</label>
                <input class="form-check-input mt-0" id="under" name="aboveBelow" type="radio" value="under"
                       @if(request('aboveBelow') == "under") checked @endif>
                <label class="ms-1" for="under">以下</label>
            </div>
        </div>
        <div class="col-4">
            <select class="form-select" name="element">
                @foreach(config('products.element') as $key => $value)
                    <option value={{ $key }} @if(request('element') == $key))
                    selected @endif>{{ "並び替え：" . $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4">
            <select class="form-select" name="direction">
                @foreach(config('products.direction') as $key => $value)
                    <option value={{ $key }} @if(request('direction') == $key))
                selected @endif>{{ "並び替え方向：" . $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-2">
            <select class="form-select" name="count">
                @foreach(config('products.count') as $value)
                    <option value={{ $value }} @if(request('count') == $value))
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
    <a href="{{ route('admin.products.create') }}" class="btn btn-success">新規</a>
</div>
<div class="col-12 my-3">
    <table class="table table-striped border-top">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">商品カテゴリ</th>
            <th scope="col">名称</th>
            <th scope="col">価格</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <th scope="row">{{ $product->id }}</th>
                <td>{{ $product->productCategory->name }}</td>
                <td>
                    <a href="{{ route('admin.products.show', ['product' => $product]) }}">
                        {{ $product->name }}
                    </a>
                </td>
                <td>{{ "¥" . number_format($product->price) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $products->links() }}
@endsection
