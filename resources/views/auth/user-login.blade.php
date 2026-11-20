@extends('layouts.auth')

@section('title', 'Traveler login')
@section('image', 'user-login.jpg')

@section('content')
<form class="form" method="POST" action="/login" novalidate>
    @csrf
    <input type="hidden" name="role" value="user">

    <span class="badge">Traveler login</span>

    <div>
        <h1>Welcome back</h1>
        <p class="sub">Good to see you again. Let us pick up where you left off.</p>
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
    <p class="center">Hotel staff or admin? <a href="/admin-login">Use the admin login</a></p>
</form>
@endsection