@extends('layouts.admin')

@section('adminContent')
<div class="col-12 my-3 d-flex gap-2">
    <a href="{{ route('admin.admin_users.index') }}" class="btn btn-white me-2">一覧</a>
    <a href="{{ route('admin.admin_users.edit', ['admin_user' => $adminUser]) }}" class="btn btn-success">編集</a>
    <form method="POST" action="{{ route('admin.admin_users.destroy', ['admin_user' => $adminUser]) }}">
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
            <td>{{ $adminUser->id }}</td>
        </tr>
        <tr>
            <th scope="row">名称</th>
            <td>{{ $adminUser->name }}</td>
        </tr>
        <tr>
            <th scope="row">メールアドレス</th>
            <td>{{ $adminUser->email }}</td>
        </tr>
        <tr>
            <th scope="row">権限</th>
            <td>{{ $adminUser->is_owner == "0" ? '一般' : 'オーナー' }}</td>
        </tr>
        </tbody>
    </table>
</div>
@endsection
