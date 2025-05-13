<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
Route::middleware('auth', 'verified')->group(function () {

    Route::post('/favorite', [FavoriteController::class, 'store']);

    Route::post('/reserve', [ReservationController::class, 'store']);
    Route::get('/done', function () {
        return view('done');
    });
    Route::patch('/reserve/delete', [ReservationController::class, 'destroy']);
    Route::patch('/reserve/update', [ReservationController::class, 'update']);

    Route::get('/mypage', [UserController::class, 'index']);

    Route::get('/detail/reserve-edit/{shop_id}', [ShopController::class, 'edit']);

    Route::post('review', [ReviewController::class, 'store']);

    Route::get('review/{shop_id}', [ReviewController::class, 'create']);
    Route::post('review/register', [ReviewController::class, 'storeReview']);
    Route::get('review/edit/{shop_id}', [ReviewController::class, 'editReview']);
    Route::patch('review/update', [ReviewController::class, 'updateReview']);
    Route::patch('review/delete/{review}', [ReviewController::class, 'destroyReview']);

    Route::get('/admin/register-owner', [AdminController::class, 'createOwner']);
    Route::post('/admin/register-owner', [AdminController::class, 'storeOwner']);
    Route::get('/admin/send-notification', [AdminController::class, 'createNotification']);
    Route::post('/admin/send-notification', [AdminController::class, 'sendNotification']);

    Route::get('/owner', [OwnerController::class, 'index']);
    Route::get('/owner/register-shop', [OwnerController::class, 'createShop']);
    Route::post('/owner/register-shop', [OwnerController::class, 'storeShop']);
    Route::get('/owner/edit-shop/{shop_id}', [OwnerController::class, 'editShop']);
    Route::patch('/owner/edit-shop/{shop_id}', [OwnerController::class, 'updateShop']);

    Route::get('/owner/reservation/{shop_id}', [OwnerController::class, 'showReservation']);

});

// Email Verification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// メール確認通知再送信
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'ご登録のメールアドレス宛に再送信しました。');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
