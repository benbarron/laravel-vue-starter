@extends('auth.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2">
                <div class="alert alert-danger mt-5">
                    <p>
                        <b>Unauthorized!</b> <small>The link you used was either invalid
                        or expired. To reset your password
                        <a href="{{ url('/password/forgot') }}">please try again. </a></small>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
