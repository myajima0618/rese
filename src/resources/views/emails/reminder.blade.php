@component('mail::message')
# 本日のご予約のお知らせ

# {{ $user->name }} 様

いつもご利用ありがとうございます。

本日、以下のご予約がございますので、お知らせいたします。

**レストラン名:** {{ $reservation->shop->shop_name }}<br>
**予約日時:** {{ \Carbon\Carbon::parse($reservation->date)->format('Y年m月d日') }} {{ \Carbon\Carbon::parse($reservation->time)->format('H:i') }}<br>
**予約人数:** {{ $reservation->number }}名<br>

ご来店を心よりお待ちしております。

@component('mail::button', ['url' => 'http://localhost'])
予約詳細を確認する
@endcomponent

今後ともよろしくお願いいたします。<br>
{{ config('app.name') }}
@endcomponent