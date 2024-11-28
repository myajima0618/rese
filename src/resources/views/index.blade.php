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
                <form action="/favorite" method="post">
                    @csrf
                    <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
                    @if(isset($shop['favorite']))
                    <button type="submit" class="shop__button-favorite change"></button>
                    @else
                    <button type="submit" class="shop__button-favorite"></button>
                    @endif
                </form>
            </div>
        </div>
    </div>
    @endforeach


</div>
<!--
<script>
    $(".shop__button-favorite").on("click", function() {
        $(this).toggleClass("change");
    });
</script>
-->
@endsection

<!--
@if(Auth::check())
    <h2>
        さんお疲れ様です
    </h2>
    @endif
    main page

    <form class="form" action="/logout" method="post">
        @csrf
        <button class="header-nav__button">ログアウト</button>
    </form>
-->