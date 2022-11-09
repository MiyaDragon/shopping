@extends('layouts.app')

@section('title', 'Shopping')

@section('content')
<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.home') }}">Shopping</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::User()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.admin_users.show', ['admin_user' => Auth::User()]) }}">管理者情報</a>
                        </li>
                        <div class="dropdown-divider"></div>
                        <li><button class="dropdown-item" form="logout_btn">ログアウト</button></li>
                    </ul>
                    <form method="POST" action="{{ route('admin.logout') }}" id="logout_btn">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-2 bg-light vh-100 border-end">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ url()->current() == route('admin.products.index')
                        ? "text-primary" : "text-dark" }}" href="{{ route('admin.products.index') }}">
                        商品管理
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ url()->current() == route('admin.product_categories.index')
                        ? "text-primary" : "text-dark" }}" href="{{ route('admin.product_categories.index') }}">
                        商品カテゴリ管理
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ url()->current() == route('admin.users.index')
                        ? "text-primary" : "text-dark" }}" href="{{ route('admin.users.index') }}">
                        顧客管理
                    </a>
                </li>
                @if (Auth::User()->is_owner)
                    <li class="nav-item">
                        <a class="nav-link {{ url()->current() == route('admin.admin_users.index')
                            ? "text-primary" : "text-dark" }}" href="{{ route('admin.admin_users.index') }}">
                            管理者管理
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <div class="col-md-10">
            <div class="container">
                @yield('adminContent')
            </div>
        </div>
    </div>
</div>
@endsection
