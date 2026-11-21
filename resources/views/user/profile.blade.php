@extends('layouts.user')

@section('title', 'Profile')
@section('heading', 'Your profile')

@section('content')
<a href="{{ route('planning.index') }}" class="btn-back">
    ← Back to My Trips
</a>
<form class="card" method="POST" action="/profile" novalidate style="display:flex;flex-direction:column;gap:20px">
    @csrf

    <div style="display:flex;align-items:center;gap:16px">
        <div class="avatar" style="width:72px;height:72px;font-size:24px">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
        <div>
            <b style="font-size:18px">{{ $user->name }}</b><br>
            <span class="pill">{{ $user->role === 'admin' ? 'Admin account' : 'Traveler account' }}</span>
        </div>
    </div>

    <div class="grid2">
        <div>
            <label class="lb">Full name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Your full name">
        </div>
        <div>
            <label class="lb">Email address</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="you@example.com">
        </div>
        <div>
            <label class="lb">Phone number</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Your phone number">
        </div>
        <div>
            <label class="lb">Location</label>
            <input type="text" name="location" value="{{ old('location', $user->location) }}" placeholder="Your location">
        </div>
        <div>
            <label class="lb">Preferred language</label>
            <input type="text" name="language" value="{{ old('language', $user->language) }}" placeholder="Your language">
        </div>
        <div>
            <label class="lb">Currency</label>
            <input type="text" name="currency" value="{{ old('currency', $user->currency) }}" placeholder="LKR (Rs.)">
        </div>
    </div>

    @if (session('success'))
        <p class="sub" style="color:#1E7A47;margin:0">{{ session('success') }}</p>
    @endif
    @if ($errors->any())
        <p class="error">{{ $errors->first() }}</p>
    @endif

    <div class="actions">
        <a class="btn outline" href="/dashboard" style="display:flex;align-items:center;height:50px">Cancel</a>
        <button class="btn" type="submit">Save changes</button>
    </div>
</form>
@endsection