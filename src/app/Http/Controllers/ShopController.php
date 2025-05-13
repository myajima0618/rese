<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
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
        $sort = $request->sort;

        // 飲食店情報取得クエリの初期化
        $shopsQuery = Shop::with('area', 'category')
            ->AreaSearch($area_id)
            ->CategorySearch($category_id)
            ->KeywordSearch($keyword);

        // 並び替えロジック
        switch ($sort) {
            case 'random':
                $shops = $shopsQuery->inRandomOrder()->get();
                break;
            case 'rating_desc':
                $shops = $shopsQuery->leftJoin('reviews', 'shops.id', '=', 'reviews.shop_id')
                    ->select('shops.*', DB::raw('AVG(reviews.rating) as average_rating'))
                    ->groupBy('shops.id')
                    ->orderByDesc('average_rating')
                    ->orderBy('shops.id') // 評価が同じ場合は店舗IDで安定ソート
                    ->get();
                break;
            case 'rating_asc':
                $shops = $shopsQuery->leftJoin('reviews', 'shops.id', '=', 'reviews.shop_id')
                    ->select('shops.*', DB::raw('AVG(reviews.rating) as average_rating'))
                    ->groupBy('shops.id')
                    ->orderByRaw('CASE WHEN average_rating IS NULL THEN 1 ELSE 0 END ASC') // 評価なしを最後に
                    ->orderBy('average_rating')
                    ->orderBy('shops.id') // 評価が同じ場合は店舗IDで安定ソート
                    ->get();
                break;
            default:
                $shops = $shopsQuery->get(); // デフォルトの並び順 (現在の取得順を維持)
                break;
        }

        foreach ($shops as $shop) {
            $imagePath = 'image/' . $shop['image_url']; // publicディレクトリのパス
            if (!File::exists($imagePath)) {
                $imagePath = 'storage/shop/' . $shop['image_url']; // storageディレクトリのパス
            }
            $shop['image_path'] = $imagePath;
        }

        // リクエストパラメータを配列に格納
        $param = [];
        $param['area_id'] = $area_id;
        $param['category_id'] = $category_id;
        $param['keyword'] = $keyword;
        $param['sort'] = $sort;

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

        $imagePath = 'image/' . $shop['image_url']; // publicディレクトリのパス
        if (!File::exists($imagePath)) {
            $imagePath = 'storage/shop/' . $shop['image_url']; // storageディレクトリのパス
        }
        $shop['image_path'] = $imagePath;

        // 時間と人数の配列取得
        $times = $this->getTimeArray();
        $numbers = $this->getNumberArray();

        // 口コミ全件取得
        $all_reviews = Review::where('shop_id', $shop_id)
            ->whereNull('delete_flag')
            ->orderBy('updated_at', 'DESC')
            ->get();

        foreach ($all_reviews as $all_review) {
            $reviewImagePath = 'image/' . $all_review['review_image']; // publicディレクトリのパス
            if (!File::exists($reviewImagePath)) {
                $reviewImagePath = 'storage/' . $all_review['review_image']; // storageディレクトリのパス
                if (!File::exists($reviewImagePath)) {
                    $reviewImagePath = 'https://placehold.jp/500x300.png?text=No Image';
                }
            }

            $all_review['review_image_path'] = $reviewImagePath;
        }

        // 現在認証しているユーザー
        $user = Auth::user();
        $user_review = null; // 初期化

        // ログインしている場合
        if ($user) {
            $review = null; // 初期化
            // ログインしているユーザーの権限が店舗代表者または管理者だった場合
            if ($user['role'] == 10 || $user['role'] == 99) {
                // 何も処理を取得処理を行わずview表示
                return view('detail', compact('shop', 'user', 'times', 'numbers', 'all_reviews'));
            }
            // 予約情報取得
            $reservation = Reservation::where('user_id', $user['id'])
                ->where('shop_id', $shop_id)
                ->orderBy('date', 'DESC')
                ->first();

            if ($reservation) {
                // format change
                $time = new CarbonImmutable($reservation['time']);
                $reservation['time'] = $time->format('H:i');

                $today = new CarbonImmutable();
                $date = new CarbonImmutable($reservation['date'] . $reservation['time']);

                // 取得した予約情報の予約日時が今日よりも過去だったら
                if ($date->lt($today)) {
                    $reservation['date_check'] = true;
                } else {
                    $reservation['date_check'] = false;
                }

                // レビュー情報取得
                $review = Review::where('reservation_id', $reservation['id'])->get();
                $firstReview = null; // 初期化

                // レビュー情報が存在したら
                if (!empty($review)) {
                    foreach ($review as $value) {
                        $firstReview = $value;
                    }
                    $review = $firstReview;
                } else {
                    $review = null;
                }

                // ログイン中のユーザーの口コミ情報取得
                $user_review = Review::where('shop_id', $shop_id)
                    ->where('user_id', $user['id'])
                    ->orderBy('updated_at', 'DESC')
                    ->first();

                // 口コミの登録がなかったら
                if (is_null($user_review)) {
                    $user_review['review_check'] = true;
                // 口コミ登録あるが削除されている場合
                } elseif (!is_null($user_review) && $user_review['delete_flag'] == 1) {
                    $user_review['review_check'] = true;
                } else {
                    $user_review['review_check'] = false;
                }
            }
            return view('detail', compact('shop', 'user', 'times', 'numbers', 'reservation', 'review', 'user_review', 'all_reviews'));
        } else {
            return view('detail', compact('shop', 'times', 'numbers', 'user_review', 'all_reviews'));
        }
    }

    // マイページから飲食店予約情報変更ページ表示
    public function edit($shop_id, Request $request)
    {
        $shop = Shop::with('area', 'category')
            ->find($shop_id);

        $imagePath = 'image/' . $shop['image_url']; // publicディレクトリのパス
        if (!File::exists($imagePath)) {
            $imagePath = 'storage/shop/' . $shop['image_url']; // storageディレクトリのパス
        }
        $shop['image_path'] = $imagePath;

        // 口コミ全件取得
        $all_reviews = Review::where('shop_id', $shop_id)
            ->whereNull('delete_flag')
            ->orderBy('updated_at', 'DESC')
            ->get();

        foreach ($all_reviews as $all_review) {
            $reviewImagePath = 'image/' . $all_review['review_image']; // publicディレクトリのパス
            if (!File::exists($reviewImagePath)) {
                $reviewImagePath = 'storage/' . $all_review['review_image']; // storageディレクトリのパス
                if (!File::exists($reviewImagePath)) {
                    $reviewImagePath = 'https://placehold.jp/500x300.png?text=No Image';
                }
            }

            $all_review['review_image_path'] = $reviewImagePath;
        }

        // 現在認証しているユーザー
        $user = Auth::user();
        $user_review= null; // 初期化
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
        if ($date->lt($today)) {
            $reservation['date_check'] = true;
        } else {
            $reservation['date_check'] = false;
        }

        // ログイン中のユーザーの口コミ情報取得
        $user_review = Review::where('shop_id', $shop_id)
            ->where('user_id', $user['id'])
            ->orderBy('updated_at', 'DESC')
            ->first();

        // 口コミの登録がなかったら
        if (is_null($user_review)) {
            $user_review['review_check'] = true;
        // 口コミ登録あるが削除されている場合
        } elseif (!is_null($user_review) && $user_review['delete_flag'] == 1) {
            $user_review['review_check'] = true;
        } else {
            $user_review['review_check'] = false;
        }
        // レビュー情報取得
        $review = Review::where('reservation_id', $request->id)->get();
        // レビュー情報が存在したら
        if (!empty($review)) {
            foreach ($review as $value) {
                $review = $value;
            }
        }

        return view('detail', compact('shop', 'user', 'times', 'numbers', 'reservation', 'review', 'user_review', 'all_reviews'));
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
