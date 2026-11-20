
@extends('layouts.auth')

@section('title', 'Create account')
@section('image', 'register.jpg')

@section('content')
<form class="form" method="POST" action="/register" novalidate>
    @csrf

    <div>
        <h1>Create your account</h1>
        <p class="sub">Just a few details and you are in. It takes under a minute.</p>
    </div>

    <div>
        <span class="lb">How will you use Destigo?</span>
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
        <label class="lb">Full name</label>
        <input type="text" name="name" value="{{ old('name') }}" placeholder="Your full name">
    </div>

    <div>
        <label class="lb">Email address</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com">
    </div>

    <div class="row">
        <div>
            <label class="lb">Password</label>
            <input type="password" name="password" placeholder="8+ characters">
        </div>
        <div>
            <label class="lb">Confirm</label>
            <input type="password" name="password_confirmation" placeholder="Repeat it">
        </div>
    </div>

    @if ($errors->any())
        <p class="error">{{ $errors->first() }}</p>
    @endif

    <button class="btn" type="submit">Create account</button>
    <p class="center">Already with us? <a href="/login">Log in</a></p>
</form>
@endsection
