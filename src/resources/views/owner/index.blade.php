@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner.css') }}">
@endsection

@section('content')
<div class="owner__content w100">
    <div class="owner__header">
        <div class="owner-header__user">
            ログイン中：{{ $user['name'] }} さん
        </div>
    </div>
    <div class="shop-list__header">
        <h3>管理中の店舗一覧</h3>
    </div>
    <div class="shop-list__wrapper">
        @foreach($shops as $shop)
        <div class="shop__card">
            <div class="shop__image">
                <img src="{{ asset($shop['image_path']) }}" alt="">
            </div>
            <div class="shop__info">
                <div class="shop__text">
                    <div class="shop__name">
                        <h3>{{ $shop['shop_name']}}</h3>
                        <div class="shop__rating">
                            <label class="shop-rating__star"><i class="fa-solid fa-star"></i></label>
                            <span class="shop-rating__score">{{ isset($shop->average_rating) ? number_format($shop->average_rating, 2) : '評価なし' }}</span>
                        </div>
                    </div>
                    <p>
                        #{{ $shop['area']['area_name'] }}　#{{ $shop['category']['category_name'] }}
                    </p>
                </div>
                <div class="shop__button">
                    <a href="/detail/{{ $shop['id'] }}" class="shop__button-detail">詳細</a>
                    <a href="/owner/edit-shop/{{ $shop['id'] }}" class="shop__button-detail">編集</a>
                    <a href="/owner/reservation/{{ $shop['id'] }}" class="shop__button-reservation">予約一覧</a>
                    @if(Auth::check())
                    <input type="hidden" id="user_id" value="{{ $user['id'] }}">
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection