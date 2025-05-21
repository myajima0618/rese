@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/import_csv.css') }}">
@endsection

@section('content')
<div class="import-csv__content w100">
    <div class="import-csv__header">
        <div class="import-header__user">
            ログイン中：{{ $user['name'] }} さん
        </div>
    </div>
    @if ($errors->any())
    <div class="import-form__error">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="import-csv__wrapper">
        <form action="/admin/import-csv" method="POST" enctype="multipart/form-data" class="import-csv__form">
            @csrf
            <div class="import-form__heading">
                <h3>CSVインポート（店舗情報）</h3>
            </div>
            <div class="import-form__group">
                <label for="csv_file">CSVファイルを選択してください</label>
                <input type="file" class="form-control-file" id="csv_file" name="csv_file" required>
                <small class="form-text text-muted">※項目は「店舗名」「地域」「ジャンル」「店舗代表者ID」「店舗概要」「画像URL」の順で記述してください（ヘッダー行が必要です）。</small>
            </div>
            <div class="import-form__button">
                <button type="submit" class="import-form__button-submit">インポート</button>
            </div>
        </form>
    </div>
</div>

@endsection