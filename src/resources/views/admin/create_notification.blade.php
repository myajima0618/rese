@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/notification.css') }}">
@endsection

@section('content')
<div class="notification__content w100">
    <div class="notification__header">
        <div class="notification-header__user">
            ログイン中：{{ $user['name'] }} さん
        </div>
    </div>
    <div class="notification__wrapper">
        <form action="/admin/send-notification" method="post" class="notification__form">
            @csrf
            <div class="notification-form__heading">
                <h3>お知らせメール作成</h3>
            </div>
            @error('subject')
            <div class="notification-form__error">
                <div></div>
                <div class="error__message">
                    {{ $message }}
                </div>
            </div>
            @enderror
            <div class="notification-form__input-items">
                <div>Subject</div>
                <input type="text" name="subject">
            </div>
            @error('body')
            <div class="notification-form__error">
                <div></div>
                <div class="error__message">
                    {{ $message }}
                </div>
            </div>
            @enderror
            <div class="notification-form__input-items">
                <div>Message</div>
                <textarea name="body"></textarea>
            </div>
            <div class="notification-form__button">
                <button type="submit" class="notification-form__button-submit">送信</button>
            </div>
        </form>
    </div>

</div>

@endsection