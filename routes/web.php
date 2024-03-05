<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//未ログイン時のアクセス制限処理
Route::group(['middleware' => 'auth'], function() {
    //商品一覧画面へのルート
    Route::get('/product', [ProductController::class, 'product'])->name('product');

    //商品情報登録画面へのルート
    Route::get('/create', [ProductController::class, 'create'])->name('create');

    //商品情報の新規登録処理
    Route::post('/store', [ProductController::class, 'store'])->name('store');

    //商品情報詳細画面へのルート
    Route::get('/detail/{id}', [ProductController::class, 'detail'])->name('detail');

    //商品情報編集画面へのルート
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');

    //商品情報の編集処理
    Route::post('/update/{id}', [ProductController::class, 'update'])->name('update');

    //商品情報削除処理
    Route::post('/destroy{id}', [ProductController::class, 'destroy'])->name('destroy');
});
