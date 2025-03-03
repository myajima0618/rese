@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="thanks__content">
    <div class="thanks__wrapper">
        <div class="thanks__message">
            <h3>会員登録ありがとうございます</h3>
            <h4>※登録はまだ完了しておりません</h4>
            <p>
                ご登録いただいたメールアドレスに本登録用のURLを<br>記載したメールを送信いたしました。<br>
                メールに記載のURLをクリックし、登録を完了してください。
            </p>    
        </div>
        <div class="login__button">
            <a href="/login">ログインする</>
        </div>
    </div>
</div>


@endsection