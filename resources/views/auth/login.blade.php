@extends('auth.layout')

@section('content')
    <div class="content">
        <form class="auth-form" method="POST" action="{{ url('/login') }}">
            @csrf
            <div class="row my-4">
                <h4 class="heading">
                    User Login
                </h4>
            </div>
            <div class="row my-4">
                <label for="email">Email Address</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                       type="email" name="email" id="email" value="{{ old('email') }}" autofocus>
               @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>
            <div class="row my-4">
                <label for="password">Password</label>
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                       type="password" name="password" id="password" value="{{ old('password') }}" autofocus>
                @if($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </div>
            <div class="row d-flex justify-content-between my-2">
               <div>
                   <input type="checkbox" name="remember" value="{{ old('remember') }}" id="remember">
                   <label for="remember">Remember Me</label>
               </div>
                <a href="{{ url('/password/forgot') }}">Forgot Password?</a>
            </div>
            <div class="row my-3 btn-row">
                <button class="btn btn-primary">Login</button>
            </div>

        </form>
    </div>
@endsection
