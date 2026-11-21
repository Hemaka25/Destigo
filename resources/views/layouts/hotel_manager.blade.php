<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Destigo - Hotel Manager</title>

    @vite(['resources/css/app.css'])
</head>

<body>

    <div class="app-container">

        <!-- Top Navbar (same as the shared layout) -->
        <header class="top-navbar">
            <div class="logo">
                <h2>Destigo</h2>
            </div>

            <div class="user-profile">
                <span>🔔</span>
                <span>Hotel Staff</span>
            </div>
        </header>

        <!-- Main Layout -->
        <div class="main-layout">

            <!-- Hotel Manager Sidebar -->
            <aside class="sidebar hm-sidebar">
                <h3>Hotel Manager</h3>
                <ul>
                    <li class="{{ request()->routeIs('hotel.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('hotel.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="{{ request()->routeIs('hotel.rooms*') ? 'active' : '' }}">
                        <a href="{{ route('hotel.rooms') }}">Rooms</a>
                    </li>
                    <li class="{{ request()->routeIs('hotel.reservations*') ? 'active' : '' }}">
                        <a href="{{ route('hotel.reservations') }}">Reservations</a>
                    </li>
                    <li><span>Profile</span></li>
                    <li><span>Settings</span></li>
                </ul>
            </aside>

            <!-- Page Content -->
            <main class="content">
                @yield('content')
            </main>

        </div>

    </div>

</body>
</html>