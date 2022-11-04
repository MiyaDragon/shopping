@extends('layouts.admin')

@section('adminContent')
<form method="POST" action="{{ route('admin.users.update', ['user' => $user]) }}" class="mb-5" enctype="multipart/form-data">
    @method('PUT')
    @include('admin.users._form')
    <div class="col-12 mt-3">
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="delete" id="delete" value="true">
            <label class="form-check-label" for="delete">削除</label>
        </div>
        <img src="{{ asset('storage/' . $user->image_path) }}" alt="画像" width="100" height="100">
    </div>
    <hr>
    <a href="{{ route('admin.users.show', ['user' => $user]) }}" class="btn btn-secondary me-2">キャンセル</a>
    <button type="submit" class="btn btn-primary">更新</button>
</form>
@endsection
