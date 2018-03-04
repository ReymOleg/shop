<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('/public/css/app.css') }}">
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
        <link href="{{ asset('/fonts/Neucha.ttf') }}" rel="fonts">
    </head>
    <body>
        <div id="app"></div>
        <script type="text/javascript" src="{{ asset('/public/js/app.js') }}"></script>
    </body>
</html>
