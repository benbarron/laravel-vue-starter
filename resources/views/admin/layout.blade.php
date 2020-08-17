<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="app-name" content="{{ $name }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name='api-token' content="{{ $token }}">
    <title>{{ $name }}</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <root></root>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
