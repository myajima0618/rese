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

    public function detail($shop_id)
    {
        $shop = Shop::with('area', 'category')
            ->find($shop_id);

        // 現在認証しているユーザー
        $user = Auth::user();

        // 時間と人数の配列作成
        $times = [
            '12:00' => '12:00',
            '13:00' => '13:00',
            '14:00' => '14:00',
            '15:00' => '15:00',
            '16:00' => '16:00',
            '17:00' => '17:00',
            '18:00' => '18:00',
            '19:00' => '19:00',
            '20:00' => '20:00',
            '21:00' => '21:00',
        ];

        $numbers = [
            '1' => '1人',
            '2' => '2人',
            '3' => '3人',
            '4' => '4人',
            '5' => '5人',
            '6' => '6人',
            '7' => '7人',
            '8' => '8人',
            '9' => '9人',
            '10' => '10人',
        ];



        return view('detail', compact('shop', 'user', 'times', 'numbers'));
    }
}
