@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endsection

@section('content')
<div class="review__wrapper">
    @if($user_review)
    <form action="/review/update" class="review-form" method="post" enctype="multipart/form-data">
        @method('PATCH')
        @else
        <form action="/review/register" class="review-form" method="post" enctype="multipart/form-data">
            @endif
            @csrf
            <div class="review-form__inner">
                <div class="shop-box">
                    <div class="shop-box__question">
                        @if(session('error'))
                        {{ session('error') }}
                        @endif
                        <h1>今回のご利用はいかがでしたか？</h1>
                    </div>
                    <div class="shop-card__inner">
                        <div class="shop__card">
                            <div class="shop__image">
                                <img src="{{ asset($shop['image_path']) }}" alt="">
                            </div>
                            <div class="shop__info">
                                <div class="shop__text">
                                    <h3>{{ $shop['shop_name'] }}</h3>
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
                    </div>
                </div>
                <div class="border"></div>
                <div class="review-box">
                    <div class="review-box__error">
                        @error('rating')
                        {{ $message }}
                        @enderror
                    </div>
                    <div class="review-box__rating">
                        <h3>体験を評価してください</h3>
                        <div class="review-rating">
                            <input class="rating__input" id="star5" name="rating" type="radio" value="5" @if(!empty($user_review)&&$user_review['rating']==5&&$user_review['delete_flag']==null) checked @endif>
                            <label class="rating__label" for="star5"><i class="fa-solid fa-star"></i></label>

                            <input class="rating__input" id="star4" name="rating" type="radio" value="4" @if(!empty($user_review)&&$user_review['rating']==4&&$user_review['delete_flag']==null) checked @endif>
                            <label class="rating__label" for="star4"><i class="fa-solid fa-star"></i></label>

                            <input class="rating__input" id="star3" name="rating" type="radio" value="3" @if(!empty($user_review)&&$user_review['rating']==3&&$user_review['delete_flag']==null) checked @endif>
                            <label class="rating__label" for="star3"><i class="fa-solid fa-star"></i></label>

                            <input class="rating__input" id="star2" name="rating" type="radio" value="2" @if(!empty($user_review)&&$user_review['rating']==2&&$user_review['delete_flag']==null) checked @endif>
                            <label class="rating__label" for="star2"><i class="fa-solid fa-star"></i></label>

                            <input class="rating__input" id="star1" name="rating" type="radio" value="1" @if(!empty($user_review)&&$user_review['rating']==1&&$user_review['delete_flag']==null) checked @endif>
                            <label class="rating__label" for="star1"><i class="fa-solid fa-star"></i></label>
                        </div>
                    </div>
                    <div class="review-box__error">
                        @error('comment')
                        {{ $message }}
                        @enderror
                    </div>
                    <div class="review-box__comment">
                        <h3>口コミを投稿</h3>
                        <textarea name="comment" class="" placeholder="カジュアルな夜のお出かけにおすすめのスポット" onkeyup="document.getElementById('count').value=this.value.length">@if(old('comment')){{ old('comment') }} @elseif(!empty($user_review['comment'])&&$user_review['delete_flag']==null) {{ $user_review['comment'] }}@endif</textarea>
                        <p class="comment__count">
                            <input type="text" id="count" value=""></input>/400（最高文字数）
                        </p>
                    </div>
                    <div class="review-box__error">
                        @error('review_image')
                        {{ $message }}
                        @enderror
                    </div>
                    <div class="review-box__image">
                        <h3>画像の追加</h3>
                        <div id="drop-area">
                            <label for="image-upload">
                                クリックして写真を追加<br>
                                <span class="fs08">またはドラッグアンドドロップ</span>
                            </label>
                        </div>
                        <input type="file" name="review_image" id="image-upload" accept="image/*" multiple>
                        <div id="preview-area">
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
            @if($user_review)
            <input type="hidden" name="review_id" value="{{ $user_review['id'] }}">
            <input type="hidden" name="reservation_id" value="{{ $user_review['reservation_id'] }}">
            @endif
            <div class="review-form__button">
                <button type="submit" class="review-form__submit">
                    @if($user_review&&$user_review['delete_flag']==null)
                    口コミを更新
                    @else
                    口コミを投稿
                    @endif
                </button>
            </div>
        </form>
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

@section('scripts')
<script src="{{ asset('js/review_image_upload.js') }}"></script>
@endsection