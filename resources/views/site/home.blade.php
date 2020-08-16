@extends('site.layout')

@section('content')
    <div class="flex-center position-ref full-height">
        <div class="top-right links">
            @auth
                @if(Auth::user()->role == 1)
                    <a href="{{ url('/home') }}">Admin Home</a>
                @else
                    <a href="{{ url('/logout') }}">Logout</a>
                @endif
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
@endsection
