<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
   
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="main-box">
     
        <div class="left-banner" style="background-color: #1d2731;">
            <h2>Destigo</h2>
            <p>Run your platform with confidence.</p>
        </div>

        <div class="right-content">
            <span style="background-color: #ddd; padding: 3px; font-size: 12px;">Admin Portal</span>
            <h3>Admin Sign In</h3>
            
            <form>
                <label>Work Email:</label>
                <input type="email" placeholder="admin@destigo.com">

                <label>Password:</label>
                <input type="password" placeholder="Enter Password">

                <button type="button" class="submit-btn" style="background-color: #1d2731;">Sign In As Admin</button>
                
                
                <p>Not an admin? <a href='/traveler-login'>Go to Traveler Login</a></p>
            </form>
        </div>
        
        <div class="clear"></div>
    </div>

</body>
</html>

