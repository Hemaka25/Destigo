<!DOCTYPE html>
<html>
<head>
    <title>Welcome Back</title>
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="main-box">
        <div class="left-banner">
            <h2>Destigo</h2>
            <p>Your next story starts with a plan.</p>
        </div>

        <div class="right-content">
            <h3>Welcome back</h3>
            <p>Sign in as:</p>
            
            <form>
                <p>
                    <input type="radio" name="login-role" checked> I am a traveler <br>
                    <input type="radio" name="login-role"> I am an admin
                </p>

                <!-- Meka oya kalinma hariyata dala thibba -->
                <button type="button" class="submit-btn" onclick="location.href='/traveler-login'">Continue to Login</button>
                
                <!-- Meka oya kalinma hariyata dala thibba -->
                <p>New here?  <a href="/register">Create an account</a></p>
            </form>
        </div>
        
        <div class="clear"></div>
    </div>

</body>
</html>
