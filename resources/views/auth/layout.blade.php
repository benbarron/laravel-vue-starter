<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
   <div class="container">
       <nav class="nav">
           <div class="nav-left">
               <a href="{{ url('/') }}" class="branding">{{ env('APP_NAME') }}</a>
           </div>
           <div class="nav-right">
               <ul>
                   <li><a href="{{ url('/login') }}">Login</a></li>
                   <li><a href="{{ url('/register') }}">Register</a></li>
               </ul>
           </div>
       </nav>
   </div>
    @yield('content')
</body>

</html>
