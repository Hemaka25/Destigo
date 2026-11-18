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
                <span>Welcome, User</span>
            </div>
        </header>

        <!-- Main Layout -->
        <div class="main-layout">

            <!-- Sidebar -->
            <aside class="sidebar">
                <h3>Menu</h3>
                <ul>
                    <li>Dashboard</li>
                    <li>My Trips</li>
                    <li class="{{ request()->is('hotel_booking*') ? 'active' : '' }}">Bookings</li>
                    <li>Profiles</li>
                    <li>Settings</li>
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