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
                        オーナー管理者
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">管理者情報</a></li>
                        <div class="dropdown-divider"></div>
                        <li><a class="dropdown-item" href="#">ログアウト</a></li>
                    </ul>
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
                    <a class="nav-link text-dark" href="#">
                        顧客管理
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">
                        管理者管理
                    </a>
                </li>
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
