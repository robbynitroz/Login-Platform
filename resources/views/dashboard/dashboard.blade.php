<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>


</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
<div id="app">
<router-view></router-view>
</div>
<!-- Scripts -->
<script src="{{ asset('js/dashboard/dashboard.js') }}"></script>
<!-- Styles -->
<link href="{{ asset('css/dashboard/dashboard.css') }}" rel="stylesheet">
</body>
</html>
