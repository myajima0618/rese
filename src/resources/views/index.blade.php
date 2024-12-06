@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="shop-list__wrapper">
    @foreach($shops as $shop)
    <div class="shop__card">
        <div class="shop__image">
            <img src="{{ asset($shop['image_url']) }}" alt="">
        </div>
        <div class="shop__info">
            <div class="shop__text">
                <h3>{{ $shop['shop_name'] }}</h3>
                <p>
                    #{{ $shop['area']['area_name'] }}　#{{ $shop['category']['category_name'] }}
                </p>
            </div>
            <div class="shop__button">
                <a href="/detail" class="shop__button-detail">詳しく見る</a>
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
