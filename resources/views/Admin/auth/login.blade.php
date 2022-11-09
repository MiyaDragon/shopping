@extends('layouts.app')

@section('content')
    <main class="form-signin">
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="text-center">
                <h1 class="h3">管理画面</h1>
            </div>
            <div class="form-floating">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="メールアドレス">
                <label for="email">メールアドレス</label>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-floating">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="パスワード">
                <label for="password">パスワード</label>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">ログイン</button>
        </form>
    </main>
@endsection
