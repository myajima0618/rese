<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser as FortifyCreateNewUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Area;
use App\Models\Category;
use App\Models\Shop;
use App\Models\User;
use App\Models\Review;
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

        $targets = User::where('role', '1')->get();
        foreach ($targets as $target) {
            Mail::to($target->email)->send(new SendEmail($target, $subject, $body));
        }

        return redirect('/done')->with('role', $user['role'])->with('message', 'お知らせメールの送信が完了しました');
    }

    /*************************** */
    /* 口コミ削除処理（プロ入会テスト）
    /*************************** */
    public function destroyReview(Review $review)
    {
        // ログインしているユーザー
        $user = Auth::user();

        $review->update(['delete_flag' => 1]);
        return redirect('/done')->with('role', $user['role'])->with('message', '口コミ情報を削除しました。');
    }
    /*************************** */
    /* CSVインポート画面表示（プロ入会テスト）
    /*************************** */
    public function createImportCsv()
    {
        // ログインしているユーザー
        $user = Auth::user();

        return view('admin.import_csv', compact('user'));
    }

    /*************************** */
    /* CSVインポート処理（プロ入会テスト）
    /*************************** */
    public function importShop(Request $request)
    {
        // ログインしているユーザー
        $user = Auth::user();

        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        if ($request->hasFile('csv_file')) {
            $file = $request->file('csv_file');
            $path = $file->getRealPath();
            $data = array_map('str_getcsv', file($file->getRealPath()));
            $header = array_shift($data);

            $errors = [];
            $importedCount = 0;

            foreach ($data as $row) {
                if (count($row) !== 6) {
                    $errors[] = '行の項目数が不正です。[必要な項目数:6つ]';
                    continue;
                }
                $rowData = array_combine($header, $row);

                $validator = Validator::make($rowData, [
                    '店舗名' => ['required', 'string', 'max:50'],
                    '地域' => ['required', 'string', Rule::in(['東京都', '大阪府', '福岡県'])],
                    'ジャンル' => ['required', 'string', Rule::in(['寿司', '焼肉', 'イタリアン', '居酒屋', 'ラーメン'])],
                    '店舗代表者ID' => ['required', 'string'],
                    '店舗概要' => ['required', 'string', 'max:400'],
                    '画像URL' => ['required', 'string'],
                ]);

                if ($validator->fails()) {
                    $errors[] = 'バリデーションエラー：' . implode(', ', $validator->errors()->all()) . ' (店舗名: ' . ($rowData['店舗名'] ?? '不明') . ')';
                    continue;
                }

                // 画像URLの拡張子チェック
                $imageUrl = $rowData['画像URL'];
                $allowedExtensions = ['jpg', 'jpeg', 'png'];
                $extension = strtolower(pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION));

                if (!in_array($extension, $allowedExtensions)) {
                    $errors[] = '画像URLの拡張子が不正です。jpg、jpeg、pngのみ対応しています。 (店舗名: ' . $rowData['店舗名'] . ')';
                    continue;
                }

                // エリア名称から情報を取得する
                $area = Area::where('area_name', $rowData['地域'])->first();
                // ジャンル名称から情報を取得する
                $category = Category::where('category_name', $rowData['ジャンル'])->first();


                // データベースへの保存処理
                $shop = new Shop();
                $shop->shop_name = $rowData['店舗名'];
                $shop->area_id = $area['id'];
                $shop->category_id = $category['id'];
                $shop->user_id = $rowData['店舗代表者'];
                $shop->description = $rowData['店舗概要'];
                $shop->image_url = $imageUrl;
                $shop->save();
                $importedCount++;
            }
            if (!empty($errors)) {
                return back()->withErrors($errors);
            }

            return redirect('/done')->with('role', $user['role'])->with('message', $importedCount . '件の店舗情報をインポートしました。');
        }

        return back()->withErrors(['csv_file' => 'CSVファイルのアップロードに失敗しました。']);
    }
}
