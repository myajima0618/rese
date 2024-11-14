@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register__content">
    <div class="register__wrapper">
        <form action="/register" method="post" class="register-form">
            @csrf
            <div class="register-form__heading">
                <h3>Registration</h3>
            </div>
            <div class="register-form__group">
                <div class="register-form__input--user">
                    <input type="text" name="name" placeholder="Username" value="">
                </div>
                <div class="register-form__input--mail">
                    <input type="text" name="email" placeholder="Email" value="">
                </div>
                <div class="register-form__input--password">
                    <input type="text" name="password" placeholder="Password">
                </div>
                <div class="register-form__button">
                    <button type="submit" class="register-form__button-submit">登録</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection