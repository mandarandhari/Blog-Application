@extends('layouts.app')

@section('content')
<header class="masthead" style="background-image: url('/img/bg-profile.jpg')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="page-heading">
                    <h1>Profile</h1>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <form method="POST" action="{{ route('update_profile') }}">
                @method('PATCH')
                @csrf
                <div class="control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <label>Name</label>
                        <input type="text" class="form-control" placeholder="Name" id="name" name="name" value="{{ old('name') ? old('name') : Auth::user()->name }}" autofocus>
                        @error('name')
                        <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <label>Email Address</label>
                        <input type="email" class="form-control" placeholder="Email Address" id="email" name="email" value="{{ Auth::user()->email }}" disabled>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <label>password</label>
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                        @error('password')
                        <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" placeholder="Confirm Password" id="confirmPassword" name="password_confirmation">
                        @error('password_confirmation')
                        <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <br>  
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
