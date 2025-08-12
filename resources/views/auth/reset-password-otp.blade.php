@extends('layouts.auth')

@section('main-content')
<div class="container">
    <h2>Reset Password</h2>
    <form method="POST" action="{{ route('otp.reset') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <div class="form-group">
            <label>Password Baru</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-warning">Reset Password</button>
    </form>
</div>
@endsection
