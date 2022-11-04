@extends('layouts.admin')

@section('adminContent')
<div class="col-12 my-3 d-flex gap-2">
    <a href="{{ route('admin.users.index') }}" class="btn btn-white me-2">一覧</a>
    <a href="{{ route('admin.users.edit', ['user' => $user]) }}" class="btn btn-success">編集</a>
    <form method="POST" action="{{ route('admin.users.destroy', ['user' => $user]) }}">
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
                <td>{{ $user->id }}</td>
            </tr>
            <tr>
                <th scope="row">名称</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th scope="row">メールアドレス</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th scope="row">イメージ</th>
                <td>
                    <img src="{{ asset('storage/' . $user->image_path) }}" alt="画像" width="100" height="100">
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
