@extends('auth.layout')

@section('content')
    <div class="content">
        <form class="auth-form" method="POST" action="{{ url('/register') }}">
            @csrf
            <div class="row my-4">
                <h4 class="heading">
                    Create An Account
                </h4>
            </div>
            <div class="row my-4">
                <label for="name">Full Name</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                       type="text" name="name" id="name" value="{{ old('name') }}" autofocus>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
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
            <div class="row my-4">
                <label for="password_confirmation">Confirm Password</label>
                <input class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                       type="password" name="password_confirmation" id="password_confirmation"
                       value="{{ old('password_confirmation') }}" autofocus>
                @if($errors->has('password_confirmation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password_confirmation') }}
                    </div>
                @endif
            </div>
            <div class="row my-5 btn-row">
                <button class="btn btn-primary">Create Account</button>
            </div>
        </form>
    </div>
@endsection
