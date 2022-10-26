@extends('layouts.admin')

@section('adminContent')
<form method="POST" action="{{ route('admin.admin_users.store') }}">
    @include('admin.admin_users._form')
    <hr>
    <a href="{{ route('admin.admin_users.index') }}" class="btn btn-secondary me-2">キャンセル</a>
    <button type="submit" class="btn btn-primary">作成</button>
</form>
@endsection