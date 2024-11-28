@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register__content">
    <div class="register__wrapper">
        <form action="/register" method="post" class="register-form" novalidate>
            @csrf
            <div class="register-form__heading">
                <h3>Registration</h3>
            </div>
            <div class="register-form__group">
                <div class="register-form__error">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
                <div class="register-form__input--user">
                    <input type="text" name="name" placeholder="Username" value="{{ old('name') }}">
                </div>
                <div class="register-form__error">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
                <div class="register-form__input--mail">
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                </div>
                <div class="register-form__error">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
                <div class="register-form__input--password">
                    <input type="password" name="password" placeholder="Password">
                </div>
                <div class="register-form__button">
                    <button type="submit" class="register-form__button-submit">登録</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection