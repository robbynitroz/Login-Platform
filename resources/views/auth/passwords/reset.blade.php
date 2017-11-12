<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="GuestCompass">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="theme-color" content="#2087b0"/>
    <meta name="background_color" content="#2087b0"/>
    <link rel="manifest" type="text/plain" href="/manifest.json">
    <title>GuestCompass</title>
    {{--Favicons for every device--}}
    <link rel="apple-touch-icon" sizes="57x57" href="/storage/icons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/storage/icons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/storage/icons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/storage/icons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/storage/icons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/storage/icons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/storage/icons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/storage/icons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/storage/icons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/storage/icons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512"  href="/storage/icons/android-icon-512x512.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/storage/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/storage/icons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/storage/icons/favicon-16x16.png">
    <meta name="msapplication-TileImage" content="/storage/icons/ms-icon-144x144.png">



</head>
<body>
<noscript>Please enable JavaScript in order to use platform</noscript>
<div id="app">
    <router-view></router-view>
</div>
<script src="{{ asset('js/login/auth.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/login/auth.css') }}" type="text/css">
<style type="text/css">
    @font-face {
        font-family: Russo One;
        src: url(/storage/fonts/RussoOne-Regular.ttf);
    }
</style>
</body>
</html>
