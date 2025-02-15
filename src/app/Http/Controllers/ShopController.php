<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Reservation;
use App\Models\Review;
use Carbon\CarbonImmutable;

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

    // 飲食店詳細ページ表示
    public function detail($shop_id)
    {
        $shop = Shop::with('area', 'category')
            ->find($shop_id);
        // 現在認証しているユーザー
        $user = Auth::user();

        // 時間と人数の配列取得
        $times = $this->getTimeArray();
        $numbers = $this->getNumberArray();

        return view('detail', compact('shop', 'user', 'times', 'numbers'));
    }

    // マイページから飲食店予約情報変更ページ表示
    public function edit($shop_id, Request $request)
    {
        $shop = Shop::with('area', 'category')
            ->find($shop_id);
        // 現在認証しているユーザー
        $user = Auth::user();
        // 時間配列取得
        $times = $this->getTimeArray();
        // 人数配列取得
        $numbers = $this->getNumberArray();

        // 予約情報取得
        $reservation = Reservation::where('id', $request->id)->get();
        // format change
        $time = new CarbonImmutable($reservation[0]['time']);
        $reservation[0]['time'] = $time->format('H:i');
        $reservation = $reservation[0];

        $today = new CarbonImmutable();
        $date = new CarbonImmutable($reservation['date']);
        if($date->lt($today)){
            $reservation['date_check'] = true;
        } else {
            $reservation['date_check'] = false;
        }

        // レビュー情報取得
        $review = Review::where('reservation_id', $request->id)->get();
        // レビュー情報が存在したら
        if(!empty($review)) {
            foreach($review as $value) {
                $review = $value;
            }
        }
        
        return view('detail', compact('shop', 'user', 'times', 'numbers', 'reservation', 'review'));

    }

    private function getTimeArray()
    {
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
            '22:00' => '22:00',
        ];
        return $times;
    }

    private function getNumberArray()
    {
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
        return $numbers;
    }
}
