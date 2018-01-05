<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="manifest" type="text/plain" href="/manifest.json">
    <title>{{ $hotel_name or 'NewsFeed' }}</title>
</head>
<body>
<div id="app">
<main-page></main-page>
</div>
<!-- Scripts -->
<script src="{{ asset('js/newsfeed/newsfeed.js') }}"></script>
<!-- Styles -->
<link href="{{ asset('css/newsfeed/newsfeed.css') }}" rel="stylesheet">
</body>
</html>
