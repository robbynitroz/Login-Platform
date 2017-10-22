<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="ip" content="{{ $ip_address }}">
    <script id="mainData" type="application/json">{!! $data !!}</script>
    <link rel="manifest" type="text/plain" href="/manifest.json">

    <title>Welcome</title>

</head>
<body>
<div id="app">
    <login-home></login-home>
</div>
</div>
<link rel="stylesheet" href="css/app.css" type="text/css">
<script src="js/app.js"></script>
</body>
</html>
