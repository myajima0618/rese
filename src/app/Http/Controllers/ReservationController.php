<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use Carbon\Carbon;
use Carbon\CarbonImmutable;


class ReservationController extends Controller
{
    public function store(ReservationRequest $request)
    {
        // 現在認証しているユーザー
        $user = Auth::user();

        // ログインしていない場合はログイン画面へ遷移
        if(!$user) {
            return view('auth.login');
        } else {
            $params = $request->only(['user_id', 'shop_id', 'time', 'number']);

            // 日付をY-m-d式に変換
            $date = CarbonImmutable::parse($request->date)->format('Y-m-d');

            // 登録するアイテム
            $items = [
                'user_id' => $params['user_id'],
                'shop_id' => $params['shop_id'],
                'date' => $date,
                'time' => $params['time'],
                'number' => $params['number'],
            ];
            // 登録処理
            Reservation::create($items);

            return redirect('/done');

        }

    }
}
