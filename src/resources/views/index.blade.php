@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="shop-list__wrapper">
    @foreach($shops as $shop)
    <div class="shop__card">
        <div class="shop__image">
            <img src="{{ asset($shop['image_path']) }}" alt="">
        </div>
        <div class="shop__info">
            <div class="shop__text">
                <div class="shop__name">
                    <h3>{{ $shop['shop_name'] }}</h3>
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
                <a href="/detail/{{ $shop['id'] }}" class="shop__button-detail">詳しく見る</a>
                @if($shop->checkFavorite())
                <button class="shop__button-favorite change" data-shop-id="{{ $shop['id'] }}"></button>
                @else
                <button class="shop__button-favorite" data-shop-id="{{ $shop['id'] }}"></button>
                @endif
                @if(Auth::check())
                <input type="hidden" id="user_id" value="{{ $user['id'] }}">
                @endif
            </div>
        </div>
    </div>
    @endforeach


</div>
<script>
    window.addEventListener('DOMContentLoaded', function() {
        $(function() {
            let favorite = $('.shop__button-favorite');
            let favoriteShopId;

            favorite.on('click', function() {
                // ログインしていない場合はログイン画面へ遷移
                if (!($('#user_id').length)) {
                    window.location.href = "/login";
                }

                let $this = $(this);
                favoriteShopId = $this.data('shop-id');
                $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/favorite',
                        method: "POST",
                        data: {
                            'shop_id': favoriteShopId,
                        },
                    })
                    .done(function() {
                        $this.toggleClass('change');
                    })
                    .fail(function() {
                        console.log('fail');
                    })
            })
        })
    });
</script>
@endsection