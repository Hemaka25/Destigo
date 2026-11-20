
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Destigo</title>

    @vite(['resources/css/app.css'])
</head>

<body>

    <div class="app-container">

        <!-- Top Navbar -->
        <header class="top-navbar">
            <div class="logo">
                <h2>Destigo</h2>
            </div>

            <div class="user-profile">
                <span>🔔</span>
                <span>Welcome, {{ auth()->user()->full_name ?? 'User' }}</span>
            </div>
        </header>

        <!-- Main Layout -->
        <div class="main-layout">

            <!-- Sidebar -->
            <aside class="sidebar">

                <h3>Menu</h3>

                <ul>

                    <!-- Dashboard -->
                    <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                        <a href="{{ url('/dashboard') }}">
                            Dashboard
                        </a>
                    </li>

                    <!-- My Trips -->
                    <li class="{{ request()->is('my_trips*') ? 'active' : '' }}">
                        <a href="#">
                            My Trips
                        </a>
                    </li>

                    <!-- Bookings / Booking History -->
                    <li class="{{ request()->is('booking_history') ? 'active' : '' }}">
                        <a href="{{ url('/booking_history') }}">
                            Bookings
                        </a>
                    </li>

                    <!-- Profile -->
                    <li class="{{ request()->is('profile') ? 'active' : '' }}">
                        <a href="{{ url('/profile') }}">
                            Profile
                        </a>
                    </li>

                    <!-- Settings -->
                    <li>
                        <a href="#">
                            Settings
                        </a>
                    </li>

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
