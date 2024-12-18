<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
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

/* 会員登録サンクスページ */
Route::get('/thanks', function () {
    return view('auth.thanks');
});

Route::get('/', [ShopController::class, 'index']);
Route::get('/detail/{shop_id}', [ShopController::class, 'detail']);

Route::get('/search', [ShopController::class, 'search']);

// 認証されていない状態でアクセスするとログイン画面にリダイレクトされる
//Route::middleware('auth')->group(function () {

    Route::post('/favorite', [FavoriteController::class, 'store']);

    Route::post('/reserve', [ReservationController::class, 'store']);
    Route::get('/done', function () {
        return view('done');
    });

    Route::get('/mypage', [UserController::class, 'index']);

//});