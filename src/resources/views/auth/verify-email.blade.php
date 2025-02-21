@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="thanks__content">
    <div class="thanks__wrapper">
        <div class="thanks__message">
            <h3>仮登録完了</h3>
            <h4>※登録はまだ完了しておりません</h4>
            <p>
                ご登録いただいたメールアドレスに本登録用のURLを<br>記載したメールを送信いたしました。<br>
                メールに記載のURLをクリックし、登録を完了してください。
            </p>
            <form method="post" action="/email/verification-notification">
                @csrf
                <div class="mail__resend">
                    <button class="mail__resend-submit">確認メール再送信</button>
                </div>
                @if(session('message'))
                <div class="mail__resend-alert">
                    <h4>{{ session('message') }}</h4>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection