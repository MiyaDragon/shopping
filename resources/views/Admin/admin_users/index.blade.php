@extends('layouts.admin')

@section('adminContent')
<div class="card shadow border-0 my-3 py-4 px-3">
    <form method="GET" action="{{ route('admin.admin_users.index') }}" class="row g-3">
        <div class="col-6">
            <input type="text" class="form-control" name="keyword" placeholder="名称"
                   value="{{ request('keyword') }}">
        </div>
        <div class="col-6">
            <input type="text" class="form-control" name="email" placeholder="メールアドレス"
                   value="{{ request('email') }}">
        </div>
        <div class="col-12">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_owner" id="all" value="all" checked>
                <label class="form-check-label" for="all">すべての権限</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_owner" id="general" value="0"
                       @if(request('is_owner') == "0")) checked @endif>
                <label class="form-check-label" for="general">一般</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_owner" id="owner" value="1"
                       @if(request('is_owner') == "1") checked @endif>
                <label class="form-check-label" for="owner">オーナー</label>
            </div>
        </div>
        <div class="col-4">
            <select class="form-select" name="element">
                @foreach(config('admin_users.element') as $key => $value)
                    <option value={{ $key }} @if((request('element') == $key))
                    selected @endif>{{ "並び替え：" . $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4">
            <select class="form-select" name="direction">
                @foreach(config('admin_users.direction') as $key => $value)
                    <option value={{ $key }} @if((request('direction') == $key))
                selected @endif>{{ "並び替え方向：" . $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-2">
            <select class="form-select" name="count">
                @foreach(config('admin_users.count') as $value)
                    <option value={{ $value }} @if((request('count') == $value))
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
    <a href="{{ route('admin.admin_users.create') }}" class="btn btn-success">新規</a>
</div>
<div class="col-12 my-3">
    <table class="table table-striped border-top">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">名称</th>
            <th scope="col">メールアドレス</th>
            <th scope="col">権限</th>
        </tr>
        </thead>
        <tbody>
        @foreach($adminUsers as $adminUser)
            <tr>
                <th scope="row">{{ $adminUser->id }}</th>
                <td>
                    <a href="{{ route('admin.admin_users.show', ['admin_user' => $adminUser]) }}">
                        {{ $adminUser->name }}
                    </a>
                </td>
                <td>{{ $adminUser->email }}</td>
                <td>{{ $adminUser->is_owner == "0" ? '一般' : 'オーナー' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $adminUsers->appends(request()->input())->links() }}
@endsection
