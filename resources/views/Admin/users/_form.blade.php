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
    <input type="text" class="form-control" id="name" name="name" placeholder="名称" value="{{ old('name', $user->name) }}">
</div>
<div class="col-12 mt-3">
    <label class="form-label" for="email">メールアドレス</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="メールアドレス" value="{{ old('email', $user->email) }}">
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
    <label class="form-label" for="image">イメージ</label>
    <input class="form-control mb-3" type="file" id="image" name="image_path">
</div>