@extends('auth.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                <div class="alert alert-success mt-5">
                    <b>Success</b> - You password has been reset! You
                    should now be able to login to your account.
                    <a href="{{ url('/login') }}">Back To Login</a>
                </div>
            </div>
        </div>
    </div>
@endsection
