@extends('auth.layout')

@section('content')
<div class="content">
    <form class="auth-form" method="POST" action="{{ url('/password/forgot') }}">
        @csrf
        <div class="row my-4">
            <h4 class="heading">
                Forgot Password
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
        <div class="row my-3 btn-row">
            <button class="btn btn-primary">Send Reset Email</button>
        </div>
    </form>
</div>
@endsection
