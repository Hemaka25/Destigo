@extends('layouts.auth')

@section('title', 'Log in')
@section('image', 'login.jpg')

@section('content')
<form class="form" method="POST" action="/login" novalidate>
    @csrf

    <div>
        <h1>Welcome back</h1>
        <p class="sub">Good to see you again. Let us pick up where you left off.</p>
    </div>

    @if (session('success'))
        <p class="sub" style="color:#1E7A47">{{ session('success') }}</p>
    @endif

    <div>
        <span class="lb">Sign in as</span>
        <div class="roles">
            <label class="role">
                <input type="radio" name="role" value="user" {{ old('role', 'user') === 'user' ? 'checked' : '' }}>
                <div><b>I am a traveler</b><span>Plan trips and book hotels</span></div>
            </label>
            <label class="role">
                <input type="radio" name="role" value="admin" {{ old('role') === 'admin' ? 'checked' : '' }}>
                <div><b>I am an admin</b><span>Manage hotels and reservations</span></div>
            </label>
        </div>
    </div>

    <div>
        <label class="lb">Email address</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com">
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

    <button class="btn" type="submit">Log in</button>
    <p class="center">New here? <a href="/register">Create an account</a></p>
</form>
@endsection