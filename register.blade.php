<!DOCTYPE html>
<html>
<head>
    <title>Destigo Registration</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>

<div class="main-box">

    <div class="left-banner">
        <h2>Destigo</h2>
        <p>Your next story starts with a plan.</p>
    </div>

    <div class="right-content">
        <h3>Create your account</h3>

        <form>
            <p>
                <input type="radio" name="role" checked> I am a traveler
                <br>
                <input type="radio" name="role"> I am an admin
            </p>

            <label>Full Name:</label>
            <input type="text" placeholder="Enter Full Name">

            <label>Email Address:</label>
            <input type="email" placeholder="Enter Email">

            <label>Password:</label>
            <input type="password" placeholder="Enter Password">

            <p>Already with us? <a href="#">Log in</a></p>

            <button type="button" class="submit-btn">
                Create Account
            </button>
        </form>
    </div>

    <div class="clear"></div>
</div>

</body>
</html>
