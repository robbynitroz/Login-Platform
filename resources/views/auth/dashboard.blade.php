<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>


</head>
<body>
<div id="app">
<dashboard></dashboard>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
</body>
</html>
