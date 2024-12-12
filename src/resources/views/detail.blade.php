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
        <div class="detail-box__image">
            <img src="{{ asset($shop['image_url']) }}" alt="">
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
        <form action="/reserve" method="post">
            @csrf
            <div class="reservation-box__header">
                <h3>予約</h3>
            </div>
            <div class="reservation-box__input">
                <div class="reservation-box__error">
                    @error('date')
                    {{ $message }}
                    @enderror
                </div>
                <div class="reservation-box__input-date">
                    <input type="text" id="datepicker" name="date" value="{{ old('date') }}">
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
                        <option value="{{ $time['key'] }}" {{ old('time')==$time['key'] ? 'selected' : '' }}>{{ $time['value'] }}</option>
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
                        <option value="{{ $number['key'] }}" {{ old('number')==$number['key'] ? 'selected' : '' }}>{{ $number['value'] }}</option>
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
                        <td class="reservation-box__selected-item" id="selected_date"></td>
                    </tr>
                    <tr class="reservation-box__selected-row">
                        <td class="reservation-box__selected-heading">Time</td>
                        <td class="reservation-box__selected-item" id="selected_time">
                            @if(old('time'))
                            {{ old('time') }}
                            @endif
                        </td>
                    </tr>
                    <tr class="reservation-box__selected-row">
                        <td class="reservation-box__selected-heading">Number</td>
                        <td class="reservation-box__selected-item" id="selected_number">
                            @if(old('number'))
                            {{ old('number') }}人
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="reservation-box__button">
                <button class="reservation-box__button-submit">予約する</button>
            </div>
            @if(Auth::check())
            <input type="hidden" id="user_id" name="user_id" value="{{ $user['id'] }}">
            @endif
            <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
        </form>
    </div>
</div>

@endsection