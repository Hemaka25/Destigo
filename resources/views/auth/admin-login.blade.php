@extends('layouts.auth')

@section('title', 'Admin sign in')
@section('image', 'admin-login.jpg')
@section('brand_class', 'admin')
@section('tagline', 'Run your platform with confidence.')

@section('content')
<form class="form" method="POST" action="/login" novalidate>
    @csrf
    <input type="hidden" name="role" value="admin">

    <span class="badge admin">Admin portal</span>

    <div>
        <h1>Admin sign in</h1>
        <p class="sub">Use your staff email to manage hotels and reservations.</p>
    </div>

    <div>
        <label class="lb">Work email</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@destigo.com">
    </div>

    <div>
        <label class="lb">Password</label>
        <input type="password" name="password" placeholder="Your password">
    </div>

    <div class="between">
        <label><input type="checkbox" name="remember"> Keep me signed in</label>
        <a href="/forgot-password">Forgot password?</a>
    </div>

    @if ($errors->any())
        <p class="error">{{ $errors->first() }}</p>
    @endif

    <button class="btn teal" type="submit">Sign in to admin portal</button>
    <p class="center">Not an admin? <a href="/user-login">Go to traveler login</a></p>
</form>
@endsection