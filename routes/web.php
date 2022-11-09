<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProductCategoriesController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\UsersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * 管理サイド
 */
Route::namespace('App\Http\Controllers\Admin')->prefix('admin')->name('admin.')->group(function () {
    Auth::routes([
        'register' => false,
        'reset' => false,
        'verify' => false,
    ]);
    Route::middleware('auth:admin')->group(function () {
        Route::get('/home', HomeController::class)->name('home');
        Route::resource('/product_categories', ProductCategoriesController::class);
        Route::resource('/products', ProductsController::class);
        Route::resource('/admin_users', AdminUsersController::class);
        Route::resource('/users', UsersController::class);
    });

});

/**
 * リダイレクト
 */
Route::redirect('/admin', '/admin/home');
