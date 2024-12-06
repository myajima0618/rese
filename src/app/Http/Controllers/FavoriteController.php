<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        // ログイン中のユーザー
        $user = Auth::user();
        $shop_id = $request->shop_id;
        // ログイン中のユーザーがその店をお気に入り登録しているか取得
        $favorite_on = Favorite::where('user_id', $user['id'])
            ->where('shop_id', $shop_id)
            ->first();
        // お気に入り登録してなかったら登録、すでに登録している場合は削除する
        if (!$favorite_on) {
            Favorite::create([
                'user_id' => $user['id'],
                'shop_id' => $shop_id
            ]);
        } else {
            Favorite::where('user_id', $user['id'])
                ->where('shop_id', $shop_id)
                ->delete();
        }

        return redirect()->back();
    }
}
