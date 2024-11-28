<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Category;
use App\Models\Favorite;

class ShopController extends Controller
{
    /* 店舗一覧表示 */
    public function index()
    {
        // エリア情報、ジャンル情報取得
        $areas = Area::all();
        $categories = Category::all();

        // 現在認証しているユーザー
        $user = Auth::user();

        // 飲食店情報取得
        $shops = Shop::with('area', 'category')->get();

        if(isset($user)){
            // ユーザーに紐づくお気に入り情報取得
            foreach ($shops as $shop) {
                $favorite = Favorite::where('shop_id', $shop['id'])
                    ->where('user_id', $user['id'])
                    ->first();
                $shop['favorite'] = $favorite;
            }
        }

        return view('index', compact('areas', 'categories', 'shops', 'user'));
    }
}
