@extends('auth.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2">
                <div class="alert alert-success mt-5">
                    <p>
                        <b>Success</b> - <small>You password has been reset! You
                        should now be able to login to your account.
                        <a href="{{ url('/login') }}">Back To Login</a></small>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
