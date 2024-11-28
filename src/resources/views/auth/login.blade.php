@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login__content">
    <div class="login__wrapper">
        <form action="/login" method="post" class="login-form" novalidate>
            @csrf
            <div class="login-form__heading">
                <h3>Login</h3>
            </div>
            <div class="login-form__group">
                <div class="login-form__error">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
                <div class="login-form__input--mail">
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                </div>
                <div class="login-form__error">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
                <div class="login-form__input--password">
                    <input type="password" name="password" placeholder="Password">
                </div>
                <div class="login-form__button">
                    <button type="submit" class="login-form__button-submit">ログイン</button>
                </div>
            </div>

        </form>
    </div>
</div>


@endsection