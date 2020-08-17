@extends('site.layout')

@section('content')
    <div>
        <div class="container">
            <nav class="nav">
                <div class="nav-left">
                    <a href="{{ url('/') }}" class="branding">{{ env('APP_NAME') }}</a>
                </div>
                <div class="nav-right">
                    <ul>
                        @auth
                            @if(Auth::user()->role == 1)
                                <li><a href="{{ url('/home') }}">Admin Home</a></li>
                            @else
                                <li><a href="{{ url('/logout') }}">Logout</a></li>
                            @endif
                        @else
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Register</a></li>
                        @endauth

                    </ul>
                </div>
            </nav>
        </div>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    <img class="swiss" src="{{ url('img/camper-swiss-knife.jpg') }}">
                </div>
                <div class="links">
                    <h1 class="brand-heading">Laravel <span style="color: #F4D8D8">Starter Kit</span></h1>
                    <h4 class="subheading">Powered by VueJS + Material Design</h4>
                </div>
            </div>
        </div>
    </div>
@endsection
