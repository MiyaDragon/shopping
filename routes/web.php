<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;

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
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

/**
 * リダイレクト
 */
Route::redirect('/admin', '/admin/home');
