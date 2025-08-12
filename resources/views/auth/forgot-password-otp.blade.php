@extends('layouts.auth')

@section('main-content')
<div class="container">
    <h2>Kirim OTP ke Email</h2>
    <form method="POST" action="{{ route('otp.send') }}">
        @csrf
        <div class="form-group">
            <label for="email">Alamat Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Kirim OTP</button>
    </form>
</div>
@endsection
