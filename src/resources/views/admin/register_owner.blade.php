@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register_owner.css') }}">
@endsection

@section('content')
<div class="owner-register__content w100">
    <div class="owner-register__header">
        <div class="register-header__user">
            ログイン中：{{ $user['name'] }} さん
        </div>
    </div>
    <div class="owner-register__wrapper">
        <form action="/admin/register-owner" method="post" class="owner-register__form" novalidate>
            @csrf
            <div class="register-form__heading">
                <h3>店舗代表者登録</h3>
            </div>
            <div class="register-form__group">
                <div class="register-form__error">
                    <div></div>
                    <div class="error__message">
                        @error('name')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="register-form__input-items">
                    <div>Username</div>
                    <input type="text" name="name" value="{{ old('name') }}">
                </div>
                <div class="register-form__error">
                    <div></div>
                    <div class="error__message">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="register-form__input-items">
                    <div>Email</div>
                    <input type="email" name="email" value="{{ old('email') }}">
                </div>
                <div class="register-form__error">
                    <div></div>
                    <div class="error__message">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="register-form__input-items">
                    <div>Password</div>
                    <input type="password" name="password">
                </div>
            </div>
            <div class="register-form__button">
                <button type="submit" class="register-form__button-submit">登録</button>
            </div>
        </form>

    </div>
</div>

@endsection