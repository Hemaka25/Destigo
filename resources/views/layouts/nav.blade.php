
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
                <h2>Destigo<span>.</span></h2>
            </div>

            <div class="user-profile">

                <span class="notification-icon">🔔</span>

                @auth
                    <div class="profile-dropdown">

                        <button type="button" class="profile-dropdown-btn">
                            <span class="profile-avatar">
                                {{ strtoupper(substr(auth()->user()->full_name, 0, 1)) }}
                            </span>

                            {{ auth()->user()->full_name }}

                            <span class="dropdown-arrow">▼</span>
                        </button>

                        <div class="profile-dropdown-content">

                            <a href="{{ url('/profile') }}">My Profile</a>

                            <form action="{{ url('/logout') }}" method="POST">
                                @csrf
                                <button type="submit">Logout</button>
                            </form>

                        </div>
                    </div>
                @else
                    <div class="profile-dropdown">

                        <button type="button" class="profile-dropdown-btn">
                            My Account
                            <span class="dropdown-arrow">▼</span>
                        </button>

                        <div class="profile-dropdown-content">
                            <a href="{{ url('/login') }}">Login</a>
                            <a href="{{ url('/register') }}">Create Account</a>
                        </div>

                    </div>
                @endauth

            </div>
        </header>

        <!-- Main Layout -->
        <div class="main-layout">

            <!-- Sidebar -->
            <aside class="sidebar">

                <h3>MAIN MENU</h3>

                <ul>

                    <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                        <a href="{{ url('/dashboard') }}">
                            <span>▦</span>
                            Dashboard
                        </a>
                    </li>

                    <li class="{{ request()->is('my_trips*') ? 'active' : '' }}">
                        <a href="#">
                            <span>✈</span>
                            My Trips
                        </a>
                    </li>

                    <li class="{{ request()->is('booking_history') ? 'active' : '' }}">
                        <a href="{{ url('/booking_history') }}">
                            <span>▤</span>
                            Bookings
                        </a>
                    </li>

                    <li class="{{ request()->is('profile') ? 'active' : '' }}">
                        <a href="{{ url('/profile') }}">
                            <span>♙</span>
                            Profile
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <span>⚙</span>
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
