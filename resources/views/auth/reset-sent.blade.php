@extends('auth.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                <div class="alert alert-success mt-5">
                    <b>Success</b> - If an account exists with {{ $email  }}, then we will
                    send an email with password reset instructions. <a href="{{ url('/login') }}">Back To Login</a>
                </div>
            </div>
        </div>
    </div>
@endsection
