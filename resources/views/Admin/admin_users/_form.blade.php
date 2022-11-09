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
    <input type="text" class="form-control" id="name" name="name" placeholder="名称" value="{{ old('name', $adminUser->name) }}">
</div>
<div class="col-12 mt-3">
    <label class="form-label" for="email">メールアドレス</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="メールアドレス" value="{{ old('email', $adminUser->email) }}">
</div>
<div class="col-12 mt-3">
    <label class="form-label" for="password">パスワード</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="パスワード">
</div>
<div class="col-12 mt-3">
    <label class="form-label" for="password_confirmation">パスワード(確認)</label>
    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="パスワード(確認)">
</div>
@if (Auth::User()->is_owner && Auth::User() != $adminUser)
    <div class="col-12 mt-3">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="is_owner" id="general" value="0" checked>
            <label class="form-check-label" for="general">一般</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="is_owner" id="owner" value="1" @if($adminUser->is_owner) checked @endif>
            <label class="form-check-label" for="owner">オーナー</label>
        </div>
    </div>
@else
    <div class="col-12 mt-3">
        <label class="form-check-label">{{ $adminUser->is_owner ? 'オーナー' : '一般' }}</label>
        <input type="hidden" name="is_owner" value="{{ $adminUser->is_owner ?? 0 }}">
    </div>
@endif