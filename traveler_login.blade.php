<!DOCTYPE html>
<html>
<head>
    <title>Traveler Login</title>
   
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="main-box">
        <div class="left-banner">
            <h2>Destigo</h2>
            <p>Your next story starts with a plan.</p>
        </div>

        <div class="right-content">
            <span style="background-color: #ddd; padding: 3px; font-size: 12px;">Traveler Login</span>
            <h3>Welcome back</h3>
            
            <form>
                <label>Email Address:</label>
                <input type="email" placeholder="you@example.com">

                <label>Password:</label>
                <input type="password" placeholder="Enter Password">

                <p><input type="checkbox"> Keep me signed in</p>

                <button type="button" class="submit-btn">Log In</button>
                
                
                <p>New here? <a href="/register">Create account</a></p>
             
                <p>Hotel owner? <a href="/admin-login">Go to Admin Login</a></p>
            </form>
        </div>
        
        <div class="clear"></div>
    </div>

</body>
</html>
