<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title') | Destigo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
</head>
<body>
<div class="app">
    <aside class="sidebar">
        <div class="logo">Destigo</div>
        <a class="nav {{ request()->is('dashboard') ? 'on' : '' }}" href="/dashboard">Dashboard</a>
        <a class="nav" href="#">My trips</a>
        <a class="nav" href="#">Bookings</a>
        <a class="nav {{ request()->is('profile') ? 'on' : '' }}" href="/profile">Profile</a>

        <form method="POST" action="/logout" style="margin-top:auto">
            @csrf
            <button class="nav logout" type="submit">Log out</button>
        </form>
    </aside>
    <main class="content">
        <div class="top">
            <h1>@yield('heading')</h1>
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
        </div>
        @yield('content')
    </main>
</div>
</body>
</html>