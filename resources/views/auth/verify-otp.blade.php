@extends('layouts.auth')

@section('main-content')
<div class="container">
    <h2>Verifikasi OTP</h2>
    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf
        <input type="hidden" name="email" value="{{ session('email') }}">
        <div class="form-group">
            <label for="otp">Kode OTP</label>
            <input type="text" class="form-control" name="otp" required>
        </div>
        <button type="submit" class="btn btn-success">Verifikasi</button>
    </form>
</div>
@endsection
