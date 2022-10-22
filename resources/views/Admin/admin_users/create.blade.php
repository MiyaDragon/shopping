@extends('layouts.admin')

@section('adminContent')
<form method="POST" action="{{ route('admin.admin_users.store') }}">
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
    <div class="col-12 mt-3">
        <label class="form-label" for="name">名称</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="名称" value="{{ old('name') }}">
    </div>
    <div class="col-12 mt-3">
        <label class="form-label" for="email">メールアドレス</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="メールアドレス" value="{{ old('email') }}">
    </div>
    <div class="col-12 mt-3">
        <label class="form-label" for="password">パスワード</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="パスワード">
    </div>
    <div class="col-12 mt-3">
        <label class="form-label" for="password_confirmation">パスワード(確認)</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="パスワード(確認)">
    </div>
    <div class="col-12 mt-3">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="is_owner" id="general" value="0" checked>
            <label class="form-check-label" for="general">一般</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="is_owner" id="owner" value="1">
            <label class="form-check-label" for="owner">オーナー</label>
        </div>
    </div>
    <hr>
    <a href="{{ route('admin.admin_users.index') }}" class="btn btn-secondary me-2">キャンセル</a>
    <button type="submit" class="btn btn-primary">作成</button>
</form>
@endsection
