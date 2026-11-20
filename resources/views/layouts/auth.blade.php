<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title') | Destigo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
<div class="page">
    <aside class="brand @yield('brand_class')">
        <div class="logo">Destigo</div>
        <div class="photo @yield('photo_class')" style="background-image:url('{{ asset('images/' . $__env->yieldContent('image')) }}'),linear-gradient(135deg,#4aa3b3,#173D59)"></div>
        <h2>@yield('tagline', 'Your next story starts with a plan.')</h2>
    </aside>
    <main class="side">
        @yield('content')
    </main>
</div>
</body>
</html>