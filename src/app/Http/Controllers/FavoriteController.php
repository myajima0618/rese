<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store(Request $request) 
    {
        // 現在認証しているユーザー
        $user = Auth::user();
        // ログインしていない場合はログイン画面へ遷移
        if(!isset($user)){
            return view('auth.login');
        } else {
            $shop_id = $request->shop_id;

            // favoritesテーブルに登録する配列
            $items = [
                'user_id' => $user['id'],
                'shop_id' => $shop_id,
            ];

            Favorite::create($items);

            return redirect('/');
        }

    }
}
