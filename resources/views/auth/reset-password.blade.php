@extends('auth.layout')

@section('content')
<div class="content">
    <form class="auth-form" method="POST" action="{{ url('/password/reset') }}">
        @csrf
        <div class="row my-4">
            <h4 class="heading">
                Reset Password
            </h4>
        </div>
        <div class="row my-4">
            <label for="password">New Password</label>
            <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                   type="password" name="password" id="password" value="{{ old('password') }}" autofocus>
            <input type="hidden" name="userId" value="{{ $userId }}"><input type="hidden" name="token" value="{{ $token }}">
            @if($errors->has('password'))
                <div class="invalid-feedback">
                    {{ $errors->first('password') }}
                </div>
            @endif
        </div>
        <div class="row my-3 btn-row">
            <button class="btn btn-primary">Update Password</button>
        </div>
    </form>
</div>
@endsection
