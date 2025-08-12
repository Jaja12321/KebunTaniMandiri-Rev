@extends('layouts.auth')

@section('main-content')
<div class="container">
    <img class="wave" src="{{ asset('img/wave.png') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 d-flex justify-content-center">
                <div class="img">
                    <img src="{{ asset('img/bg.svg') }}">
                </div>

                <div class="login-content">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <img src="{{ asset('img/avatar6.jpg') }}">
                        <h2 class="title">Welcome</h2>

                        @if ($errors->any())
                        <div class="alert alert-danger border-left-danger" role="alert">
                            <ul class="pl-4 my-2">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="input-div one">
                            <div class="i">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="div">
                                <h5>Email</h5>
                                <input type="email" name="email" class="input" value="{{ old('email') }}" required autofocus>
                            </div>
                        </div>

                        <div class="input-div pass">
                            <div class="i">
                                <i class="fas fa-lock"></i>
                            </div>
                            <div class="div">
                                <h5>Password</h5>
                                <input type="password" name="password" class="input" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="remember">{{ __('Remember Me') }}</label>
                            </div>
                        </div>

                        <input type="submit" class="btn" value="Login">

                        <div class="text-center mt-3">
                            <a class="small text-dark" href="{{ route('otp.form') }}">
                                {{ __('Forgot Password?') }}
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section('scripts')
<script src="https://kit.fontawesome.com/a81368914c.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
@endsection
