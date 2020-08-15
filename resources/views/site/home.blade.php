<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link rel="icon" type="image/png" href="/favicon.png" />
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>

<body>
    <div class="flex-center position-ref full-height">
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">Admin Home</a>
            @else
                <a href="{{ url('/login') }}">Login</a>
                <a href="{{ url('/register') }}">Register</a>
            @endauth
        </div>
        <div class="content">
            <div class="title m-b-md">
                <img class="swiss" src="{{ url('img/camper-swiss-knife.jpg') }}">
            </div>
            <div class="links">
                <h1>Laravel <span style="color: #F4D8D8">Starter Kit</span></h1>
                <h4>Powered by VueJS + Material Design</h4>
            </div>
        </div>
    </div>
</body>

</html>
