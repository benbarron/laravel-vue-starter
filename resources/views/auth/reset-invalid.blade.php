@extends('auth.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                <div class="alert alert-danger mt-5">
                    <b>Unauthorized</b> - The link you used was either invalid
                    or expired. To reset your password
                    <a href="{{ url('/password/forgot') }}">please try again. </a>
                </div>
            </div>
        </div>
    </div>
@endsection
