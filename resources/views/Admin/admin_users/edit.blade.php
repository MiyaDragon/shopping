@extends('layouts.admin')

@section('adminContent')
<form method="POST" action="{{ route('admin.admin_users.update', ['admin_user' => $adminUser]) }}">
    @method('PUT')
    @include('admin.admin_users._form')
    <hr>
    <a href="{{ route('admin.admin_users.show', ['admin_user' => $adminUser]) }}" class="btn btn-secondary me-2">キャンセル</a>
    <button type="submit" class="btn btn-primary">更新</button>
</form>
@endsection