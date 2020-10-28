@extends('layouts.app')

@section('content')
<header class="masthead" style="background-image: url('/img/bg-login.jpg')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="page-heading">
                    <h1>Login</h1>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label>Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" id="email" name="email" value="{{ old('email') }}">
                        @error('email')
                        <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <label>Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" id="password" name="password">
                        @error('password')
                        <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" id="signinButton">{{ __('Login') }}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto text-center">
            <p>Forgot password? <a href="{{ route('password.request') }}" style="color: #3490dc !important;">Click here</a>
            <p>Don't have an account? <a href="/register" style="color: #3490dc !important;">Register here</a></p>
        </div>
    </div>
</div>
@endsection
