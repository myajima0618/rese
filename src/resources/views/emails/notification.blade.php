
@component('mail::message')
# {{ $target['name'] }} 様

{{ $body }}

@component('mail::button', ['url' => 'http://localhost'])
サイトを確認する
@endcomponent

今後ともよろしくお願いいたします。<br>
{{ config('app.name') }}
@endcomponent