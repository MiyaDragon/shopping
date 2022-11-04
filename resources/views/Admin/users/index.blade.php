@extends('layouts.admin')

@section('adminContent')
<div class="card shadow border-0 my-3 py-4 px-3">
    <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
        <div class="col-6">
            <input type="text" class="form-control" name="keyword" placeholder="名称"
                   value="{{ request('keyword') }}">
        </div>
        <div class="col-6">
            <input type="text" class="form-control" name="email" placeholder="メールアドレス"
                   value="{{ request('email') }}">
        </div>
        <div class="col-4">
            <select class="form-select" name="element">
                @foreach(config('users.element') as $key => $value)
                    <option value={{ $key }} @if(request('element') == $key))
                            selected @endif>{{ "並び替え：" . $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4">
            <select class="form-select" name="direction">
                @foreach(config('users.direction') as $key => $value)
                    <option value={{ $key }} @if(request('direction') == $key))
                            selected @endif>{{ "並び替え方向：" . $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-2">
            <select class="form-select" name="count">
                @foreach(config('users.count') as $value)
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
    <a href="{{ route('admin.users.create') }}" class="btn btn-success">新規</a>
</div>
<div class="col-12 my-3">
    <table class="table table-striped border-top">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">名称</th>
                <th scope="col">メールアドレス</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>
                        <a href="{{ route('admin.users.show', ['user' => $user]) }}">
                            {{ $user->name }}
                        </a>
                    </td>
                    <td>{{ $user->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $users->appends(request()->input())->links() }}
@endsection
