# Rese（リーズ）
ある企業のグループ会社の飲食店予約サービス
<img width="865" alt="Image" src="https://github.com/user-attachments/assets/52f1b8f4-2630-4c1e-b0b4-0c6e9185fc24" />

## 作成した目的
外部の飲食店予約サービスは手数料を取られるので自社で予約サービスを持ちたい。  
また、初年度でのユーザー数10,000人達成を目指す。

## アプリケーションURL
開発環境：http://localhost/  
phpMyAdmin：http://localhost:8080/

## 機能一覧
#### 【利用者（一般ユーザー）権限】
・会員登録  
・ユーザー情報取得  
・ユーザー飲食店お気に入り一覧取得  
・ユーザー飲食店予約情報取得  
・飲食店お気に入り追加  
・飲食店お気に入り削除  
・飲食店予約情報追加  
・飲食店予約情報変更  
・飲食店予約情報削除  
・来店後の評価投稿  
#### 【店舗代表者権限】
・飲食店情報追加  
・飲食店情報変更  
・予約情報確認  
・画像のストレージ保存  
#### 【管理者権限】
・店舗代表者追加  
・お知らせメール送信  
#### 【共通・その他】
・ログイン  
・ログアウト  
・飲食店一覧取得  
・飲食店詳細取得  
・エリア検索  
・ジャンル検索  
・店名検索  
・メール認証  
・認証・登録の際のバリデーション  
・タブレット・スマートフォン用のレスポンシブデザイン  
#### 【Pro入会テスト】
・口コミ投稿登録  
・口コミ投稿編集  
・口コミ投稿削除（一般ユーザー：自身の投稿のみ　システム管理者：全投稿に対して削除できる）
・ソート（ランダム・評価が高い順・評価が低い順）  
・CSVインポートによる店舗情報の一括新規登録


## 使用技術（実行環境）
・Laravel Framework 8.83.27  
・PHP 7.4.9  
・MySQL 8.0.26  
・phpMyAdmin 5.2.1 

## テーブル設計
![Image](https://github.com/user-attachments/assets/389a9653-b569-42cb-a5de-7e6239692635)

![Image](https://github.com/user-attachments/assets/435e2e3e-1c45-487b-ab58-90655b03cea6)

![Image](https://github.com/user-attachments/assets/1cd356fd-aa58-4e05-b197-38417fbc4cad)

## ER図
![Image](https://github.com/user-attachments/assets/db3e9aac-ec9f-4a1c-87e0-e435426f255a)

## 制限事項
・管理者権限のユーザーを登録する画面が存在しないため、シーダーファイルにてユーザー情報を追加するものとする。  
・会員登録後のメール認証を実施していない場合は、基本的にメールアドレス確認処理を促すメール再通知画面を表示させているが、  TOP画面（飲食店一覧）・飲食店詳細画面・ログイン画面・会員登録画面については、ログインしていないユーザーでも閲覧できる画面のため、メール再通知画面は表示されず、ログイン処理も行える仕様としている。  
・メール送信機能において、キューに入れてバックグランドで処理する方法をとっているが、バックグラウンドで動き続けるような処理は施していないため、メール送信処理を実行する際は、ターミナルを立ち上げ、キューワーカの実行コマンドを実行した状態で行うこと。  
## 【Pro入会テスト】 に関しての制限事項
#### 口コミ機能
・口コミ投稿機能が利用できるのは、予約日時を過ぎた時点からとする。（一般ユーザーのみ）  
#### CSVインポート機能
【CSVファイルの記述方法】  
・ファイルの拡張子は、.csvまたは.txtで作成すること。  
・1行目：ヘッダー項目を記載すること。  
・項目名：「店舗名」「地域」「ジャンル」「店舗代表者ID」「店舗概要」「画像url」  
・順番：上記の順番通りに記載すること。



## テストユーザーアカウント
##### システム管理者権限
mail:admin001@text.com  
##### 店舗代表者権限
mail:owner001@test.com  
mail:owner002@test.com  
##### 利用者権限
mail:user001@test.com  
mail:user002@test.com  
mail:user003@test.com  
mail:user004@test.com  
mail:user005@test.com  
mail:user006@test.com  
mail:user007@test.com  
mail:user008@test.com  
mail:user009@test.com  
mail:user010@test.com  

###### passwordはすべて「aaaa00000」としてシーダーファイルに登録しています。

# 環境構築

### ■Dockerビルド
##### 1．任意の場所でリポジトリをクローンする（コマンドライン）
    $ git clone git@github.com:myajima0618/rese.git
##### 2．リモートリポジトリの作成（GitHub）
##### 3．リモートリポジトリの紐付け先を変更する（コマンドライン）
    $ git remote set-url origin **作成したリポジトリのurl**
 リポジトリのurlについては、2で作成したリモートリポジトリのページに記載されているリンクをコピーする。  
 <ins>SSH を選択しているかどうかをしっかりチェックすること。</ins>  
 ＊実行前に現状のリンクを確認するコマンドを実行しておくと確認がスムーズになる。 
 
    $ git remote -v

##### 4．紐づけが成功しているかの確認（コマンドライン）
　以下コマンドを実行し、紐づけ先が自分の作成したURLになっていれば成功。  
 
	$ git remote -v
 
##### 5．現在のローカルリポジトリのデータをリモートリポジトリに反映させておく（コマンドライン）
	$ git add .
	$ git commit -m "リモートリポジトリの変更"
	$ git push origin main

##### 6．docker-compose コマンドでビルド
	$ docker compose up -d --build  
 ビルドが終了したらDocker desktopを開き、reseコンテナができているか確認する

### ■Laravelのインストール
##### 1．PHPコンテナにログイン
	$ docker compose exec php bash
##### 2．Laravelパッケージインストール 
	$ composer install
##### 3．.env.exampleファイルから.envファイルを作成
	$ cp .env.example .env
##### 4．.envファイルの環境変数を変更
　docker-compose.ymlで設定されているデータベース名、ユーザ名、パスワードを記述する
##### 5．アプリケーションキーの設定（コマンドライン）
	$ php artisan key:generate
##### 6．phpMyAdminでデータベースの存在確認（ブラウザ）
　http://localhost:8080/	にアクセスし、設定したDBが表示されていれば成功。

### ■テーブル作成
##### 1．マイグレーションファイルの作成（コマンドライン）（以下のファイルがすでに存在している場合は次へ）
	$ php artisan make:migration create_shops_table  
	$ php artisan make:migration create_reservations_table  
	$ php artisan make:migration create_favorites_table  
	$ php artisan make:migration create_areas_table  
	$ php artisan make:migration create_categories_table  
	$ php artisan make:migration create_reviews_table  
	$ php artisan make:migration create_jobs_table  
	_ usersテーブルについてはデフォルトのものを活用  
##### 2．カラム設定（マイグレーションファイルへの記述）（設定済みの場合は次へ）  
 手順1で作成したファイルにカラムの設定を行う（参照：テーブル仕様書）  
##### 3．マイグレーションの実行（コマンドライン）  
	$ php artisan migrate

### ■ダミーレコードの作成
##### 1．シーダーファイルの作成（コマンドライン）（以下のファイルがすでに存在している場合は次へ）  
	$ php artisan make:seeder AreasTableSeeder  
	$ php artisan make:seeder CategoriesTableSeeder  
	$ php artisan make:seeder ReservationsTableSeeder  
	$ php artisan make:seeder ShopsTableSeeder  
	$ php artisan make:seeder UsersTableSeeder  
##### 2．ファクトリの作成（エディタ）（以下のファイルがすでに存在している場合は次へ）
	$ php artisan make:factory ReservationFactory  
　definitonメソッドの中の [] のなかにデータの定義をする  
##### 3．シーダーファイルへの設定（エディタ）（設定済みの場合は次へ）
　手順1で作成したシーダーファイルに設定する  
　AreasTableSeeder.php　：　47都道府県  
　CategoriesTableSeeder　：　寿司、焼肉、居酒屋、イタリアン、ラーメン  
　ReservationsTableSeeder　：　ファクトリで定義したダミーデータで200レコード作成  
　ShopsTableSeeder　：　模擬案件スプレッドシートの店舗データ一覧の情報を入力  
　UsersTableSeeder　：  
　　　制限事項にも記載している通り、管理者権限ユーザーにおいては登録画面がないため、シーダーファイルで必ず設定してください。  
  
 ```PHP
    public function run()
    {
        $param = [
            'name' => 'システム管理者001',
            'email' => 'admin001@test.com',
            'password' => '$2y$10$Z7CIltwCCqFXbqULPpdxT.VjlLCXUZo3eTHxuERvPkcsrbwboUyiu',
            'role' => '99',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => '店舗代表者001',
            'email' => 'owner001@test.com',
            'password' => '$2y$10$Z7CIltwCCqFXbqULPpdxT.VjlLCXUZo3eTHxuERvPkcsrbwboUyiu',
            'role' => '10',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '店舗代表者002',
            'email' => 'owner002@test.com',
            'password' => '$2y$10$Z7CIltwCCqFXbqULPpdxT.VjlLCXUZo3eTHxuERvPkcsrbwboUyiu',
            'role' => '10',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '利用者001',
            'email' => 'user001@test.com',
            'password' => '$2y$10$Z7CIltwCCqFXbqULPpdxT.VjlLCXUZo3eTHxuERvPkcsrbwboUyiu',
            'role' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '利用者002',
            'email' => 'user002@test.com',
            'password' => '$2y$10$Z7CIltwCCqFXbqULPpdxT.VjlLCXUZo3eTHxuERvPkcsrbwboUyiu',
            'role' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '利用者003',
            'email' => 'user003@test.com',
            'password' => '$2y$10$Z7CIltwCCqFXbqULPpdxT.VjlLCXUZo3eTHxuERvPkcsrbwboUyiu',
            'role' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '利用者004',
            'email' => 'user004@test.com',
            'password' => '$2y$10$Z7CIltwCCqFXbqULPpdxT.VjlLCXUZo3eTHxuERvPkcsrbwboUyiu',
            'role' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '利用者005',
            'email' => 'user005@test.com',
            'password' => '$2y$10$Z7CIltwCCqFXbqULPpdxT.VjlLCXUZo3eTHxuERvPkcsrbwboUyiu',
            'role' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->insert($param);
　　}
```  
  管理者権限（role：99）：1レコード  
  店舗代表者権限（role：10）：2レコード  
  利用者権限（role：1）：5レコード　　　　　　作成  
  
##### 4．マイグレーションの実行（コマンドライン）  
	$ php artisan migrate:fresh  
 　　※すでにマイグレーションを実行している場合は、migrateの後に:freshをつけてコマンド実行すること。

##### 4．シーディングの実行（コマンドライン）  
	$ php artisan db:seed  

### ■Fortifyの導入
##### 1．Fortifyのインストール（コマンドライン：PHPコンテナ内）
	$ composer require laravel/fortify  
	$ php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"  
	$ php artisan migrate  
##### 2．app.phpの修正
###### ロケールの変更
	- 'locale' => 'en',
	+ 'locale' => 'ja',

###### プロバイダーの追加
	
	'providers' => [
		// 中略
		  App\Providers\RouteServiceProvider::class,
		+ App\Providers\FortifyServiceProvider::class,
	]

##### 3．FortifyServiceProvider.phpの修正
###### 以下を削除
```PHP
	public function boot()
	{
	Fortify::createUsersUsing(CreateNewUser::class);
	-         Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
	-         Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
	-         Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
	
	-         RateLimiter::for('login', function (Request $request) {
	-             $email = (string) $request->email;
	
	-             return Limit::perMinute(5)->by($email.$request->ip());
	-         });
	
	-         RateLimiter::for('two-factor', function (Request $request) {
	-             return Limit::perMinute(5)->by($request->session()->get('login.id'));
	-         });
	}
```
###### 以下を追加
```PHP
    public function register(): void
    {
        $this->app->singleton(
            RegisteredUserController::class,
            RegisterController::class
        );

    }
	public function boot(): void
	{
		Fortify::createUsersUsing(CreateNewUser::class);
		        
		Fortify::registerView(function() {
		        return view('auth.register');
		});
		
		Fortify::loginView(function () {
		        return view('auth.login');
		});
		
		RateLimiter::for('login', function (Request $request) {
		        $email = (string) $request->email;
		
		        return Limit::perMinute(10)->by($email . $request->ip());
		});
	}
```
##### 4．RouteServiceProvider.phpの修正
###### ログイン後のリダイレクト先の変更
	- public const HOME = '/dashboard';
	+ public const HOME = '/';

##### 5．日本語ファイルのインストール
　PHPコンテナ内で以下のコマンドを実行  
 
	$ composer require laravel-lang/lang:~7.0 --dev  
	$ cp -r ./vendor/laravel-lang/lang/src/ja ./resources/lang/

### ■ログイン機能のバリデーションについて
　以下のファイルを編集  
　src/vendor/laravel/fortify/src/Http/Requests/LoginRequest.php
```PHP
        return [
            Fortify::username() => 'required|string|email',←emailを追加
            'password' => 'required|string',
        ];
```
　今回は、確認用パスワードをしようしないため、以下のファイルの<b>'confirmed'</b>を削除する。
　src/app/Actions/Fortify/PasswordValidationRules.php  
```PHP
 protected function passwordRules(): array
    {
        return ['required', 'string', Password::defaults(), 'confirmed'];←「, 'confirmed'」を削除
    }
```
### 店舗画像のストレージ保存について
今回は、src/sotrage/app/publicにshopディレクトリを作成し、そこに保存できるようにする  
##### 1．shopフォルダの作成（コマンドライン）
	$ cd src/storage/app/public  

	$ mkdir shop  
##### 2．フォルダへのシンボリックリンクを作成（コマンドライン：PHPコンテナ内）  
	$ php artisan storage:link  
 
このコマンドを実行するとconfig/filesystem.phpのlinks設定に基づきシンボリックリンクを作成します。  

##### 3． config/filesystem.phpの編集
```PHP
 config/filesystem.php
    'links' => [
        public_path('storage') => storage_path('app/public/shop'),
    ],
```
##### 4．画像アップロードサイズの設定変更
　nginx/default.confとphp/php.iniに以下の記述を追加
###### nginx/default.conf
```
client_max_body_size 10（任意の数字）m;
```
###### php/php.ini
```
post_max_size = 10M
upload_max_filesize = 10M
```
###### dockerの再起動（コマンドライン上）
	$ docker-compose restart

### ■メール検証用のテストサーバMailtrapの導入
##### 1．メールアドレス確認機能を有効化する
###### config/fortify.phpの下記の記述を有効にする
```PHP
	Features::emailVerification()
```
##### 2．UserモデルにMustVerifyEmailインターフェースを実装
###### app/Models/User.php
```PHP
use Illuminate\Contracts\Auth\MustVerifyEmail;（記載がない場合は追加）
class User extends Authenticatable
↓
class User extends Authenticatable implements MustVerifyEmail
```
##### 3．メール検証用のテストサーバMailtrapの導入
###### 1．サイトへアクセスする
　https://mailtrap.io/ja/
###### 2．サインアップ
　自分の好きなアカウントでサインアップする
###### 3．ログインして設定をコピーする
　・Email Testing のMy Inboxをクリックする　
　![image](https://github.com/user-attachments/assets/dc2b9715-09f3-42c8-9449-c7cd34200456)  
　・IntegrationのCode Samplesで「PHP：Laravel7.X and 8.X」を選択し、表示されたコードをコピーする  
　![image](https://github.com/user-attachments/assets/c320fd53-0f62-48d6-afb3-addea6de91f5)  
###### 4．.envファイルの設定
　手順③でコピーしたコードを貼り付ける
```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=*******
MAIL_PASSWORD=*******
MAIL_ENCRYPTION=tls
```
　※MAIL_FROM_ADDRESSは任意のアドレスを入力する  
###### 5．middleware’verified’を追加
###### src/routes/web.php
```PHP
Route::middleware('auth', 'verified')->group(function () {
```
###### 6．src/routes/web.phpにメール認証のルーティングと再通知のルーティングを追加
###### src/routes/web.php
```PHP
// Email Verification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// メール確認通知再送信
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'ご登録のメールアドレス宛に再送信しました。');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

```
###### 7．メール本文の設定
###### src/resources/lang/ja.jsonに追加
```
    "Verify Email Address":"メールアドレス確認",
    "Please click the button below to verify your email address.":"メールアドレスの確認を行うため下記のボタンをクリックして登録を完了させてください。",
    "If you did not create an account, no further action is required.":"本メールにお心当たりがない場合はクリックする必要はございません。",
    "Hello!":"こんにちは！",
    "Regards": "どうぞよろしくお願い致します。",
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\ninto your web browser:": "もし \":actionText\" ボタンがクリックできない場合は、以下に表示されているURLを直接ブラウザにコピー&ペーストしてください。:"
```
ただし、日本語に変換できない箇所もあるため、直接メール本文のテンプレートを修正  
###### PHPコンテナ内で下記コマンドを実行
	$ php artisan vendor:publish  
###### laravel-notificationsと書かれている番号を入力し、Enter
###### src/resources/views/vendor/notifications/email.blade.php内を編集
	※@langの箇所が変更できる場所

### ■メール送信機能
##### 1. Markdown Mailableクラスの作成（コマンドライン：PHPコンテナ内）
	$ php artisan make:mail SendEmail --markdown=emails.notification
##### 2．入力ページの作成（コマンドライン上）（すでに作成されている場合は次の処理へ）
	$ cd src/resources/views/admin
 	$ touch create_notification.blade.php
##### 3．Mailableクラスの編集
###### App\Mail\SendEmail.php
##### 4．メール送信用テンプレートの編集
###### src/resources/views/emails/notification.blade.php
##### 5．メール送信処理の追加　
###### src/app/Http/Controllers/AdminController.php
##### 6．メール送信処理をキューに入れてバックグランドで処理する設定
###### PHPコンテナ内でコマンド実行
	$ php artisan queue:table  
 	$ php artisan migrate  
  ※エラーになる場合は  
  
  	$ php artisan migrate:fresh  
   	$ php artisan db:seed  
###### .envファイルの設定
```
QUEUE_CONNECTION=databaseに変更
```
###### Mailableクラスの更新
###### App\Mail\SendEmail.php
```PHP
class SendEmail extends Mailable
↓
class SendEmail extends Mailable implements ShouldQueue
```
###### キューワーカの実行（コマンドライン：PHPコンテナ内）
	$ php artisan queue:work

###### ※このワーカはターミナルを閉じると停止してしまうので、送信処理を行う場合はターミナルを立ち上げ、キューワーカの実行をした状態で行うこと。



