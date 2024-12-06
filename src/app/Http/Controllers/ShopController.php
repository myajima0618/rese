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
    /* 店舗一覧表示・検索機能 */
    public function index(Request $request)
    {
        // エリア情報、ジャンル情報取得
        $areas = Area::all();
        $categories = Category::all();

        // 現在認証しているユーザー
        $user = Auth::user();

        // リクエストパラメータ
        $area_id = $request->area_id;
        $category_id = $request->category_id;
        $keyword = $request->keyword;

        // 飲食店情報取得
        $shops = Shop::with('area', 'category')
            ->AreaSearch($area_id)
            ->CategorySearch($category_id)
            ->KeywordSearch($keyword)
            ->get();
        
        // リクエストパラメータを配列に格納
        $param = [];
        $param['area_id'] = $area_id;
        $param['category_id'] = $category_id;
        $param['keyword'] = $keyword;

        if (isset($user)) {
            // ユーザーに紐づくお気に入り情報取得
            foreach ($shops as $shop) {
                $favorite = Favorite::where('shop_id', $shop['id'])
                    ->where('user_id', $user['id'])
                    ->first();
                $shop['favorite'] = $favorite;
            }
        }

        return view('index', compact('areas', 'categories', 'shops', 'user', 'param'));
    }

}
