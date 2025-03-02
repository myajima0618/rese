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
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\NotificationRequest;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    /*************************** */
    /* 店舗代表者登録ページ表意j
    /*************************** */
    public function createOwner()
    {
        $user = Auth::user();

        return view('admin.register_owner', compact('user'));
    }

    /*************************** */
    /* 店舗代表者登録処理
    /*************************** */
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

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => '10',
        ]);

        event(new Registered($user));

        return redirect('/done')->with('role', $user['role'])->with('message', '店舗代表者の登録が完了しました。');

    }

    /*************************** */
    /* お知らせメール作成画面表示
    /*************************** */
    public function createNotification()
    {
        $user = Auth::user();

        return view('admin.create_notification', compact('user'));
    }

    /*************************** */
    /* お知らせメール送信処理
    /*************************** */
    public function sendNotification(NotificationRequest $request)
    {
        // ログイン中のユーザー
        $user = Auth::user();

        $subject = $request->input('subject');
        $body = $request->input('body');

        $targets = User::where('role' , '1')->get();
        foreach($targets as $target) {
            Mail::to($target->email)->send(new SendEmail($target, $subject, $body));
        }

        return redirect('/done')->with('role', $user['role'])->with('message', 'お知らせメールの送信が完了しました');

    }

}
