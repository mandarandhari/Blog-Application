@extends('layouts.app')

@section('content')
<header class="masthead" style="background-image: url('/img/bg-forgot-password.jpg')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="page-heading">
                    <h1>Forgot Password</h1>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <form name="forgotPassword" id="forgotPasswordForm" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Email Address" id="email" value="{{ old('email') }}" required>
                        @error('email')
                        <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" id="forgotPasswordButton">{{ __('Send Password Reset Link') }}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto text-center">
            <p>Already have account? <a href="/login" style="color: #3490dc !important;">Login</a></p>
            <p>Don't have account? <a href="/register" style="color: #3490dc !important;">Register here</a></p>
        </div>
    </div>
</div>
@endsection
