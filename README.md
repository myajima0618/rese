# rese（リーズ）
ある企業のグループ会社の飲食店予約サービス
# image挿入！！

## 作成した目的
外部の飲食店予約サービスは手数料を取られるので自社で予約サービスを持ちたい。

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
・画像のストレージ保存  

## 使用技術（実行環境）
・Laravel Framework 8.83.27  
・PHP 7.4.9  
・MySQL 8.0.26  
・phpMyAdmin 5.2.1 

## テーブル設計
![Image](https://github.com/user-attachments/assets/389a9653-b569-42cb-a5de-7e6239692635)

![Image](https://github.com/user-attachments/assets/435e2e3e-1c45-487b-ab58-90655b03cea6)

![Image](https://github.com/user-attachments/assets/518f9634-8ecd-4f89-bef2-59712e77916d)

## ER図
![Image](https://github.com/user-attachments/assets/ba7c749f-c719-44f4-a2e9-42d1e94cda81)

## seigenjikou


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
###### 以下を追加
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
##### 4．RouteServiceProvider.phpの修正
###### ログイン後のリダイレクト先の変更
	- public const HOME = '/dashboard';
	+ public const HOME = '/';

##### 5．日本語ファイルのインストール
　PHPコンテナ内で以下のコマンドを実行  
 
	$ composer require laravel-lang/lang:~7.0 --dev  
	$ cp -r ./vendor/laravel-lang/lang/src/ja ./resources/lang/

### ■メール検証用のテストサーバMailtrapの導入
##### 1．サイトへアクセスする
　https://mailtrap.io/ja/
##### 2．サインアップ
　自分の好きなアカウントでサインアップする
##### 3．ログインして設定をコピーする
　・Email Testing のMy Inboxをクリックする　
　![image](https://github.com/user-attachments/assets/dc2b9715-09f3-42c8-9449-c7cd34200456)  
　・IntegrationのCode Samplesで「PHP：Laravel7.X and 8.X」を選択し、表示されたコードをコピーする  
　![image](https://github.com/user-attachments/assets/c320fd53-0f62-48d6-afb3-addea6de91f5)  
##### 4．.envファイルに貼り付ける
　※MAIL_FROM_ADDRESSは任意のアドレスを入力する 
