<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Area;
use App\Models\Category;
use App\Models\Shop;
use App\Http\Requests\ShopRequest;
use App\Models\Reservation;
use Illuminate\Support\Carbon;
use Carbon\CarbonImmutable;

class OwnerController extends Controller
{
    /*************************** */
    /* 店舗代表者が管理する店舗一覧ページ
    /*************************** */
    public function index()
    {
        // ログイン中のユーザー
        $user = Auth::user();
        // エリア情報、ジャンル情報取得
        $shop_areas = Area::all();
        $shop_categories = Category::all();

        // ユーザーに紐づく店舗情報取得
        $shops = Shop::with('area', 'category')
                        ->where('user_id', $user['id'])
                        ->get();

        return view('owner.index', compact('user', 'shops', 'shop_areas', 'shop_categories')  );
    }

    /*************************** */
    /* 店舗情報登録ページ表示
    /*************************** */
    public function createShop()
    {
        // ログイン中のユーザー
        $user = Auth::user();
        // エリア
        $shop_areas = Area::all();
        // ジャンル
        $shop_categories = Category::all();

        return view('owner.register_shop', compact('user', 'shop_areas', 'shop_categories'));
    }

    /*************************** */
    /* 店舗情報登録処理
    /*************************** */
    public function storeShop(ShopRequest $request)
    {
        $user = Auth::user();

        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            $filename = uniqid(rand() . '_') . '_' . $file->getClientOriginalName();

            $items = $request->only(['shop_name', 'area_id', 'category_id', 'description', 'user_id']);
            $items['image_url'] = $filename;

            // ファイルが存在するか確認
            if ($file->isValid()) { // アップロードされたファイルが正常か確認
                
                $path = Storage::putFileAs('public/shop', $file, $filename); // shopディレクトリに保存
                if ($path) { // 保存に成功した場合
                    // データベースに保存
                    Shop::create($items);

                    return redirect('/done')->with('role', $user['role'])->with('message', '飲食店の登録が完了しました。');
                    //return back()->with('status', 'Image uploaded successfully!');
                } else {
                    return back()->with('error', 'Image upload failed.'); // 保存に失敗した場合
                }
            } else {
                return back()->with('error', 'Invalid uploaded file.'); // ファイルが不正な場合
            }
        }
    }

    /*************************** */
    /* 店舗情報編集ページ表示
    /*************************** */
    public function editShop($shop_id)
    {
        // ログイン中のユーザー
        $user = Auth::user();
        // エリア
        $shop_areas = Area::all();
        // ジャンル
        $shop_categories = Category::all();

        // 店舗情報取得
        $shop = Shop::with('area', 'category')
                    ->find($shop_id);

        return view('owner.register_shop', compact('user', 'shop_areas', 'shop_categories', 'shop'));
    }

    /*************************** */
    /* 店舗情報更新処理
    /*************************** */
    public function updateShop(ShopRequest $request, $shop_id)
    {
        // ログイン中のユーザー
        $user = Auth::user();
        // 店舗情報
        $shop = Shop::find($shop_id);
        // リクエストパラメータ
        $items = $request->only(['shop_name', 'area_id', 'category_id', 'description', 'user_id']);

        // 画像もアップロードされていたら
        if($request->hasFile('image_url')){

            // 保存したファイルを削除
            if ($shop->image_url) {
                Storage::disk('public')->delete('shop/' . $shop->image_url);
            }

            $file = $request->file('image_url');
            $filename = uniqid(rand() . '_') . '_' . $file->getClientOriginalName();
            $items['image_url'] = $filename;

            // アップロードされた画像を保存
            Storage::putFileAs('public/shop', $file, $filename);

        }

        // 更新処理
        $shop->update($items);

        return redirect('/done')->with('role', $user['role'])->with('message', '店舗情報の更新が完了しました。');

    }

    /*************************** */
    /* 予約確認画面表示
    /*************************** */
    public function showReservation($shop_id)
    {
        // ログイン中のユーザー
        $user = Auth::user();
        
        $today = new CarbonImmutable();
        $today = $today->format('Y-m-d');

        // 予約情報取得
        $reservations = Reservation::with('user')
                            ->where('shop_id' , $shop_id)
                            ->where('date', '>=', $today)
                            ->orderBy('date')
                            ->orderBy('time')
                            ->get();

        foreach($reservations as $reservation) {
            $reservation['time'] = CarbonImmutable::parse($reservation['time'])->format('H:i');

            // もし予約日付が本日より前だったらフラグを立てる
            // 現時点では使わない（レビュー投稿されたかも情報に乗せる場合必要になる）
            if($reservation['date'] < $today){
                $reservation['date_flag'] = 1;
            }
        }

        return view('owner.reservation', compact('user', 'reservations'));
    }

}
