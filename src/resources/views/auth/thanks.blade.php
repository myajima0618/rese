@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="thanks__content">
    <div class="thanks__wrapper">
        <div class="thanks__message">
            <h3>会員登録ありがとうございます</h3>
        </div>
        <div class="login__button">
            <a href="/login">ログインする</>
        </div>
    </div>
</div>


@endsection