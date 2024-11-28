<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ShopController;
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

Route::post('/favorite', [FavoriteController::class, 'store']);