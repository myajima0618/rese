<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\Shop;
use App\Models\Reservation;
use DateTime;
use Carbon\CarbonImmutable;


class UserController extends Controller
{
    public function index()
    {
        // 現在認証しているユーザー
        $user = Auth::user();

        $today = new CarbonImmutable();
        // 3ヶ月前
        $start_date = $today->subMonths(3);
        // 予約情報取得(3ヶ月前以降のデータを取得する)
        $reservations = Reservation::where('user_id', $user['id'])
                            ->whereNull('delete_flag')
                            ->whereDate('date', '>=', $start_date)
                            ->orderBy('date', 'asc')
                            ->orderBy('time', 'asc')
                            ->get();
        foreach($reservations as $reservation){
            // 時間のフォーマット変更
            $time = new CarbonImmutable($reservation['time']);
            $reservation['time'] = $time->format('H:i');

            $shop = Shop::with('area', 'category')
                            ->where('id', $reservation['shop_id'])
                            ->first();
            // 予約情報に紐づく飲食店情報を配列に入れる
            $reservation['shop_info'] = $shop;
        }
        // お気に入り店舗取得
        $favorites = Favorite::where('user_id', $user['id'])->get();
        foreach($favorites as $favorite){
            $shop = Shop::with('area', 'category')
                            ->where('id', $favorite['shop_id'])
                            ->first();
            // お気に入り情報に紐づく飲食店情報を配列に入れる
            $favorite['shop_info'] = $shop;
        }

        return view('mypage', compact('user', 'reservations', 'favorites'));
    }
}
