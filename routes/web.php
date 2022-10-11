<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProductCategoriesController;

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
Route::prefix('admin')->name('admin.')->group( function () {
    Route::get('/home', HomeController::class)->name('home');
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('/product_categories', ProductCategoriesController::class);
});

/**
 * リダイレクト
 */
Route::redirect('/admin', '/admin/home');
