@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage__wrapper">
    <div class="user-info">
        <div class="user-info__left">

        </div>
        <div class="user-info__right">
            @if(Auth::check())
            <h2>
                {{ $user['name'] }}さん
            </h2>
            @endif
        </div>
    </div>
    <div class="mypage-info">
        <div class="reservation-box">
            <h3>予約状況</h3>
            @foreach($reservations as $reservation)
            <div class="reservation-card" id="card" data-reservation-id="{{ $reservation['id'] }}" data-reservation-shop-id="{{ $reservation['shop_id'] }}">

                <div class="reservation-card__heading">
                    <div class="clock"></div>
                    <div class="reservation__number">予約{{ $loop->index + 1 }}</div>
                    <form id="delete_{{ $reservation['id'] }}" action="/reserve/delete" method="post">
                        @method('PATCH')
                        @csrf
                        <input type="hidden" name="id" value="{{ $reservation['id'] }}">
                        <div class="close__button"><button type="button" data-id="{{ $reservation['id'] }}" onclick="deleteReservation(this)"></button></div>
                    </form>
                </div>
                <div class="reservation-card__content">
                    <table class="reservation-card__inner">
                        <tr class="reservation-card__row">
                            <td class="reservation-card__title">Shop</td>
                            <td class="reservation-card__item">{{ $reservation['shop_info']['shop_name'] }}</td>
                        </tr>
                        <tr class="reservation-card__row">
                            <td class="reservation-card__title">Date</td>
                            <td class="reservation-card__item">{{ $reservation['date'] }}</td>
                        </tr>
                        <tr class="reservation-card__row">
                            <td class="reservation-card__title">Time</td>
                            <td class="reservation-card__item">{{ $reservation['time'] }}</td>
                        </tr>
                        <tr class="reservation-card__row">
                            <td class="reservation-card__title">Number</td>
                            <td class="reservation-card__item">{{ $reservation['number'] }}人</td>
                        </tr>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
        <div class="favorite-box">
            <h3>お気に入り店舗</h3>
            <div class="favorite-list">
                @foreach($favorites as $favorite)
                <div class="shop__card">
                    <div class="shop__image">
                        <img src="{{ asset('storage/' . $favorite['shop_info']['image_url']) }}" alt="">
                    </div>
                    <div class="shop__info">
                        <div class="shop__text">
                            <h3>{{ $favorite['shop_info']['shop_name'] }}</h3>
                            <p>
                                #{{ $favorite['shop_info']['area']['area_name'] }}　#{{ $favorite['shop_info']['category']['category_name'] }}
                            </p>
                        </div>
                        <div class="shop__button">
                            <a href="/detail/{{ $favorite['shop_id'] }}" class="shop__button-detail">詳しく見る</a>
                            <button class="shop__button-favorite change" data-shop-id="{{ $favorite['shop_id'] }}"></button>
                            @if(Auth::check())
                            <input type="hidden" id="user_id" value="{{ $user['id'] }}">
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
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
<script>
    // カードをクリックした際のイベントリスナー
    const reservationCards = document.querySelectorAll('.reservation-card');
    reservationCards.forEach(card => {
        card.addEventListener('click', (event) => {
            // ボタン以外をクリックしたら
            if (event.target.tagName !== 'BUTTON') {
                const reservationId = card.dataset.reservationId;
                const reservationShopId = card.dataset.reservationShopId;

                // データが取得できた場合
                if (reservationId && reservationShopId) {
                    // 詳細編集ページへ遷移
                    window.location.href = `/detail/reserve-edit/${reservationShopId}?id=${reservationId}`;
                } else {
                    // エラー処理
                    console.error('予約データが見つかりません');
                }
            }
        });
    });
</script>
<script>
    // 予約情報取消時のイベント
    function deleteReservation(e) {
        'use strict'
        if (confirm('本当に削除しますか？')) {
            document.getElementById('delete_' + e.dataset.id).submit();
        }
    }
</script>
@endsection