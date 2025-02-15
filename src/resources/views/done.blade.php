@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
<div class="done__content">
    <div class="done__wrapper">
        <div class="done__message">
            @if(session('message'))
            <h3>
                {{ session('message')}}
            </h3>
            @endif
        </div>
        <div class="back__button">
            @if(session('role') && session('role') == 99)
            <a href="/admin/register-owner">戻る</>
            @elseif(session('role') && session('role') == 10)
            <a href="/owner">戻る</>
            @else
            <a href="/mypage">戻る</>
            @endif
        </div>
    </div>
</div>


@endsection