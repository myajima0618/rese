@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
<div class="done__content">
    <div class="done__wrapper">
        <div class="done__message">
            <h3>ご予約ありがとうございます</h3>
        </div>
        <div class="back__button">
            <a href="/">戻る</>
        </div>
    </div>
</div>


@endsection