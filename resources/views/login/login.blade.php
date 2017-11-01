<!doctype html>
<html lang="{{ $lang }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="sign up for free WiFi">
    <meta name="author" content="GuestCompass Login Platform">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="ip" content="{{ $ip_address }}">
    <meta name="hotel" content="{{  $hotel['id'] }}">
    <meta name="hotel-url" content="{{ $hotel['url'] }}">
    <meta name="mac-address" content="{{ $mac_address }}">
    <meta name="login-method" content="{{ $type }}">
    <meta name="fb-url" content="{{ $hotel['facebook_url'] }}">
    <script id="mainData" type="application/json">{!! $data !!}</script>
    <link rel="manifest" type="text/plain" href="/manifest.json">
    <title>{{ $hotel['name'] }}</title>
</head>
<body>
<div id="app">
    <login-home></login-home>
</div>
<script src="{{ asset('js/app.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
</body>
</html>
