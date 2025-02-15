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

        return redirect('/done')->with('message', 'ご予約ありがとうございます');
    }

    public function destroy(Request $request)
    {
        $params = [
            'delete_flag' => true
        ];

        Reservation::find($request->id)->update($params);

        return redirect('/mypage');
    }

    public function update(ReservationRequest $request)
    {
        $params = $request->only(['user_id', 'shop_id', 'date', 'time', 'number']);

        Reservation::find($request->id)->update($params);

        return redirect('/done')->with('message', '予約を変更しました');
    }
}
