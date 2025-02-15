@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
@endsection

@section('content')
<div class="reservation__content w100">
    <div class="reservation__header">
        <div class="reservation-header__user">
            ログイン中：{{ $user['name'] }} さん
        </div>
    </div>
    <div class="reservation-list__title">
        <h3>予約一覧</h3>
    </div>
    <div class="reservation-list__wrapper">
        <div class="reservation-list__back">
            <a href="/owner"></a>
        </div>
        <table class="reservation-list__inner">
            <tr class="reservation-list__row">
                <td class="reservation-list__header w10">No</td>
                <td class="reservation-list__header">Date</td>
                <td class="reservation-list__header">Time</td>
                <td class="reservation-list__header">Number</td>
                <td class="reservation-list__header">Name</td>
            </tr>
            @foreach($reservations as $key=>$reservation)
            <tr class="reservation-list__row @if(isset($reservation['date_flag'])) check @endif">
                <td class="reservation-list__items w10">{{ $key+1 }}</td>
                <td class="reservation-list__items">{{ $reservation['date'] }}</td>
                <td class="reservation-list__items">{{ $reservation['time'] }}</td>
                <td class="reservation-list__items">{{ $reservation['number'] }} 名</td>
                <td class="reservation-list__items">{{ $reservation['user']['name'] }} 様</td>

            </tr>
            @endforeach
        </table>
    </div>

</div>
@endsection