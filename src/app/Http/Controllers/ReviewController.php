<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Area;
use App\Models\Category;
use App\Models\Review;
use App\Models\Shop;
use App\Http\Requests\ReviewRequest;
use App\Models\Reservation;
use Carbon\CarbonImmutable;

class ReviewController extends Controller
{
    /*
    *   口コミ投稿入力画面表示
    */
    public function create($shop_id)
    {
        $shop = Shop::with('area', 'category')
            ->find($shop_id);

        $imagePath = 'image/' . $shop['image_url']; // publicディレクトリのパス
        if (!File::exists($imagePath)) {
            $imagePath = 'storage/shop/' . $shop['image_url']; // storageディレクトリのパス
        }
        $shop['image_path'] = $imagePath;

        // 現在認証しているユーザー
        $user = Auth::user();

        // 口コミ情報初期化
        $user_review = Review::where('user_id', $user['id'])
                            ->where('shop_id', $shop_id)
                            ->orderBy('updated_at', 'DESC')
                            ->first();
        return view('review', compact('shop', 'user', 'user_review'));
    }

    /*
    *   口コミ登録処理（Pro入会テスト）
    */
    public function storeReview(ReviewRequest $request)
    {
        // 現在認証しているユーザー
        $user = Auth::user();

        $today = new CarbonImmutable();
        // 3ヶ月前
        $start_date = $today->subMonths(3);

        // 直近3ヶ月の予約情報を取得
        $reservation = Reservation::where('user_id', $user['id'])
            ->where('shop_id', $request->shop_id)
            ->whereDate('date', '>=', $start_date)
            ->WhereDate('date', '<=', $today)
            ->orderBy('date', 'DESC')
            ->first();

        $items = $request->only(['shop_id', 'rating', 'comment']);
        $items['user_id'] = $user['id'];
        if ($reservation) {
            $items['reservation_id'] = $reservation['id'];
        }

        if ($request->hasFile('review_image')) {

            $file = $request->file('review_image');
            $now = new CarbonImmutable();
            $filename = $user['id'] . '_' . $now->format('YmdHi') . '_' . $file->getClientOriginalName();

           // ファイルが存在するか確認
            if ($file->isValid()) { // アップロードされたファイルが正常か確認
                $path = Storage::disk('public')->put('/' . $filename, file_get_contents($file));
                if($path) {
                    $items['review_image'] = $filename;

                } else {
                    return back()->with('error', 'Image upload failed.'); // 保存に失敗した場合
                }
            } else {
                return back()->with('error', 'Invalid uploaded file.'); // ファイルが不正な場合
            }

        }
        // データベースに保存
        Review::create($items);
        return redirect('/done')->with('role', $user['role'])->with('message', '口コミの投稿が完了しました。');
    }

    /*
    *   口コミ更新画面表示
    */
    public function editReview($shop_id)
    {
        // 認証中のユーザー
        $user = Auth::user();
        // 初期化
        $user_review = null;

        // 店舗情報取得
        $shop = Shop::with('area', 'category')
            ->find($shop_id);

        $imagePath = 'image/' . $shop['image_url']; // publicディレクトリのパス
        if (!File::exists($imagePath)) {
            $imagePath = 'storage/shop/' . $shop['image_url']; // storageディレクトリのパス
        }
        $shop['image_path'] = $imagePath;


        // 口コミ情報取得
        $user_review = Review::where('user_id', $user['id'])
                        ->where('shop_id', $shop_id)
                        ->whereNull('delete_flag')
                        ->orderBy('updated_at', 'DESC')
                        ->first();
        //dd($review); 
        return view('review', compact('shop', 'user', 'user_review'));

    }

    /*
    *   口コミ更新処理（Pro入会テスト）
    */
    public function updateReview(ReviewRequest $request)
    {
        // パラメータ
        $items = $request->only('rating', 'comment', 'shop_id', 'reservation_id');
        // ログイン中のユーザー
        $user = Auth::user();
        // 口コミ情報取得
        $user_review = Review::find($request->review_id);
        // delete_flagに１が入っていたら初期化する
        if ($user_review['delete_flag'] == 1) {
            $items['delete_flag'] = null;
        }
        
        // ファイルもアップロードされていたら
        if ($request->hasFile('review_image')) {

            $file = $request->file('review_image');
            $now = new CarbonImmutable();
            $filename = $user['id'] . '_' . $now->format('YmdHi') . '_' . $file->getClientOriginalName();

            // ファイルが存在するか確認
            if ($file->isValid()) { // アップロードされたファイルが正常か確認
                $path = Storage::disk('public')->put('/' . $filename, file_get_contents($file));
                if ($path) {
                    $items['review_image'] = $filename;
                } else {
                    return back()->with('error', 'Image upload failed.'); // 保存に失敗した場合
                }
            } else {
                return back()->with('error', 'Invalid uploaded file.'); // ファイルが不正な場合
            }
        }
        // 更新処理
        $user_review->update($items);

        return redirect('/done')->with('role', $user['role'])->with('message', '口コミ情報の更新が完了しました。');
    }

    /*
    *   口コミ削除処理（Pro入会テスト）
    */
    public function destroyReview(Review $review)
    {
        // ログインしているユーザー
        $user = Auth::user();
        // ログインしているユーザーのIDと口コミのuser_idが一致するか確認
        if (Auth::check() && Auth::id() == $review->user_id) {
            $review->update(['delete_flag' => 1]);
            return redirect('/done')->with('role', $user['role'])->with('message', '口コミ情報を削除しました。');
        } else {
            abort(403, '権限がありません。');
        }
    }

    public function store(ReviewRequest $request)
    {
        $review = $request->only(['user_id', 'shop_id', 'rating', 'comment']);
        $review['reservation_id'] = $request->id;
        Review::create($review);

        return redirect('/done')->with('message', '投稿ありがとうございました。');
    }
}
