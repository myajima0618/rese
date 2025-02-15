<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser as FortifyCreateNewUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function createOwner()
    {
        $user = Auth::user();

        return view('admin.register_owner', compact('user'));
    }

    public function storeOwner(Request $request)
    {
        // ログイン中のユーザー情報
        $user = Auth::user();

        // バリデーション
        $input = $request->all();

        Validator::make($input, [
            'name' => ['required', 'string', 'max:191'],
            'email' => [
                'required',
                'string',
                'email',
                'max:191',
                Rule::unique(User::class),
            ],
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->letters() // 英字を必須にする
                    ->numbers() // 数字を必須にする
            ]
        ])->validate();

        User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => '10',
        ]);

        return redirect('/done')->with('role', $user['role'])->with('message', '店舗代表者の登録が完了しました。');

    }

}
