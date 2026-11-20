@extends('layouts.auth')

@section('title', 'Forgot password')
@section('image', 'forgot.jpg')
@section('tagline', 'It happens to the best of us.')
@section('photo_class', 'contain')

@section('content')
<form class="form" method="POST" action="/forgot-password" novalidate>
    @csrf

    <a href="/login">← Back to login</a>

    <div>
        <h1>Forgot your password?</h1>
        <p class="sub">Enter your email and choose a new password.</p>
    </div>

    <div>
        <label class="lb">Email address</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com">
    </div>

    <div>
        <label class="lb">New password</label>
        <input type="password" name="password" placeholder="8+ characters">
    </div>

    <div>
        <label class="lb">Confirm password</label>
        <input type="password" name="password_confirmation" placeholder="Repeat it">
    </div>

    @if ($errors->any())
        <p class="error">{{ $errors->first() }}</p>
    @endif

    <button class="btn" type="submit">Reset password</button>
    <p class="center">Remembered it? <a href="/login">Log in</a></p>
</form>
@endsection