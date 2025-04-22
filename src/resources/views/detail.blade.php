@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<script>
    $(function() {
        $('#datepicker').datepicker({
            dateFormat: 'yy/mm/dd',
            minDate: 0
        });
    });
</script>
<script>
    $(function() {
        $('#datepicker').on('change', function() {
            let date = new Date(this.value);
            date = formatDate(date, "-");
            document.getElementById('selected_date').textContent = date;
        });
        $('#selectTime').on('change', function() {
            let time = this.value;
            document.getElementById('selected_time').textContent = time;
        });
        $('#selectNumber').on('change', function() {
            let number = this.value;
            document.getElementById('selected_number').textContent = number + "人";
        });
    });

    // 日付フォーマット関数
    function formatDate(date, sep = "") {
        const yyyy = date.getFullYear();
        const mm = ('00' + (date.getMonth() + 1)).slice(-2);
        const dd = ('00' + date.getDate()).slice(-2);

        return `${yyyy}${sep}${mm}${sep}${dd}`;
    }
</script>
<div class="detail__wrapper">
    <div class="detail-box">
        <div class="detail-box__header">
            <div class="detail-box__header-back">
                <a href="/"></a>
            </div>
            <div class="detail-box__header-name">
                <h3>{{ $shop['shop_name'] }}</h3>
            </div>
        </div>
        @php
        $imagePath = 'image/' . $shop['image_url']; // publicディレクトリのパス
        if (!File::exists($imagePath)) {
        $imagePath = 'storage/' . $shop['image_url']; // storageディレクトリのパス
        }
        @endphp
        <div class="detail-box__image">
            <img src="{{ asset($imagePath) }}" alt="">
        </div>
        <div class="detail-box__tag">
            #{{ $shop['area']['area_name'] }}　#{{ $shop['category']['category_name'] }}
        </div>
        <div class="detail-box__text">
            <p>
                {{ $shop['description'] }}
            </p>
        </div>
    </div>
    <div class="reservation-box">
        @if(isset($reservation))
        @if($reservation['date_check'])
        <form action="/review" method="post">
            @else
            <form action="/reserve/update" method="post">
                @method('PATCH')
                @endif
                @else
                <form action="/reserve" method="post">
                    @endif
                    @csrf
                    <div class="reservation-box__header">
                        <h3>予約</h3>
                    </div>
                    <div class="reservation-box__input @if (isset($reservation) && $reservation['date_check']) disabled @endif">
                        <div class="reservation-box__error">
                            @error('date')
                            {{ $message }}
                            @enderror
                        </div>
                        <div class="reservation-box__input-date">
                            @if(isset($reservation['date']))
                            <input type="text" id="datepicker" name="date" value="{{ $reservation['date'] }}" readonly>
                            @else
                            <input type="text" id="datepicker" name="date" value="{{ old('date') }}" readonly>
                            @endif
                            <div class="calendar"></div>
                        </div>
                        <div class="reservation-box__error">
                            @error('time')
                            {{ $message }}
                            @enderror
                        </div>
                        <div class="reservation-box__input-time">
                            <select name="time" id="selectTime">
                                <option value="">選択してください</option>
                                @foreach($times as $time['key'] => $time['value'])
                                @if(isset($reservation['time']))
                                <option value="{{ $time['key'] }}" {{ $reservation['time']==$time['key'] ? 'selected' : '' }}>{{ $time['value'] }}</option>
                                @else
                                <option value="{{ $time['key'] }}" {{ old('time')==$time['key'] ? 'selected' : '' }}>{{ $time['value'] }}</option>
                                @endif
                                @endforeach
                            </select>
                            <div class="polygon"></div>
                        </div>
                        <div class="reservation-box__error">
                            @error('number')
                            {{ $message }}
                            @enderror
                        </div>
                        <div class="reservation-box__input-number">
                            <select name="number" id="selectNumber">
                                <option value="">選択してください</option>
                                @foreach($numbers as $number['key'] => $number['value'])
                                @if(isset($reservation['number']))
                                <option value="{{ $number['key'] }}" {{ $reservation['number']==$number['key'] ? 'selected' : '' }}>{{ $number['value'] }}</option>
                                @else
                                <option value="{{ $number['key'] }}" {{ old('number')==$number['key'] ? 'selected' : '' }}>{{ $number['value'] }}</option>
                                @endif
                                @endforeach
                            </select>
                            <div class="polygon"></div>
                        </div>
                    </div>
                    <div class="reservation-box__selected">
                        <table class="reservation-box__selected-inner">
                            <tr class="reservation-box__selected-row">
                                <td class="reservation-box__selected-heading">Shop</td>
                                <td class="reservation-box__selected-item">{{ $shop['shop_name'] }}</td>
                            </tr>
                            <tr class="reservation-box__selected-row">
                                <td class="reservation-box__selected-heading">Date</td>
                                <td class="reservation-box__selected-item" id="selected_date">
                                    @if(old('date'))
                                    {{ old('date') }}
                                    @elseif(isset($reservation['date']))
                                    {{ $reservation['date'] }}
                                    @endif
                                </td>
                            </tr>
                            <tr class="reservation-box__selected-row">
                                <td class="reservation-box__selected-heading">Time</td>
                                <td class="reservation-box__selected-item" id="selected_time">
                                    @if(old('time')) {{ old('time') }}
                                    @elseif(isset($reservation['time']))
                                    {{ $reservation['time'] }}
                                    @endif
                                </td>
                            </tr>
                            <tr class="reservation-box__selected-row">
                                <td class="reservation-box__selected-heading">Number</td>
                                <td class="reservation-box__selected-item" id="selected_number">
                                    @if(old('number'))
                                    {{ old('number') }}人
                                    @elseif(isset($reservation['number']))
                                    {{ $reservation['number'] }}人
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    @if(isset($reservation) && $reservation['date_check'])
                    <div class="reservation-box__review">
                        <span class="review-text">
                            ご来店ありがとうございました。
                        </span>
                        <div class="reservation-box__error">
                            @error('rating')
                            {{ $message }}
                            @enderror
                        </div>
                        <div class="reservation-box__review-rating">
                            <input class="rating__input" id="star5" name="rating" type="radio" value="5" @if(!empty($review['rating'])&&$review['rating']==5) checked @endif>
                            <label class="rating__label" for="star5"><i class="fa-solid fa-star"></i></label>

                            <input class="rating__input" id="star4" name="rating" type="radio" value="4" @if(!empty($review['rating'])&&$review['rating']==4) checked @endif>
                            <label class="rating__label" for="star4"><i class="fa-solid fa-star"></i></label>

                            <input class="rating__input" id="star3" name="rating" type="radio" value="3" @if(!empty($review['rating'])&&$review['rating']==3) checked @endif>
                            <label class="rating__label" for="star3"><i class="fa-solid fa-star"></i></label>

                            <input class="rating__input" id="star2" name="rating" type="radio" value="2" @if(!empty($review['rating'])&&$review['rating']==2) checked @endif>
                            <label class="rating__label" for="star2"><i class="fa-solid fa-star"></i></label>

                            <input class="rating__input" id="star1" name="rating" type="radio" value="1" @if(!empty($review['rating'])&&$review['rating']==1) checked @endif>
                            <label class="rating__label" for="star1"><i class="fa-solid fa-star"></i></label>
                        </div>
                        <div class="reservation-box__error">
                            @error('comment')
                            {{ $message }}
                            @enderror
                        </div>
                        <div class="reservation-box__review-comment">
                            <p class="review-text">感想・ご意見</p>
                            <textarea name="comment" class="@if(!empty($review['comment'])) disabled @endif">@if(!empty($review['comment'])) {{ $review['comment'] }} @endif</textarea>
                        </div>
                    </div>
                    @endif
                    <div class="reservation-box__button">
                        @if(isset($reservation))
                        <button class="reservation-box__button-submit" @if(!empty($review['id'])) disabled @endif>
                            @if($reservation['date_check'])
                            @if(isset($review['id']))
                            レビュー投稿済み
                            @else
                            レビューを投稿する
                            @endif
                            @else
                            変更する
                            @endif
                        </button>
                        <input type="hidden" id="id" name="id" value="{{ $reservation['id'] }}">
                        @else
                        <button class="reservation-box__button-submit">予約する</button>
                        @endif
                    </div>
                    @if(Auth::check())
                    <input type="hidden" id="user_id" name="user_id" value="{{ $user['id'] }}">
                    @endif
                    <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
                </form>
    </div>
</div>

@endsection