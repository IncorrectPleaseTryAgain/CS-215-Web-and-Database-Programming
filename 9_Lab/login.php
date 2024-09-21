
<?php
//TODO 7.1: if we arrived by POST, start a session and store the username in it, 
//          then redirect to loginHistory.html
//          OPTIONAL: add your own first name and last name to the session
if($_SERVER['REQUEST_METHOD'] == "POST"){
    session_start();
    $_SESSION['username'] = $username;
    header("Location: loginHistory.php");
}


?>

<!DOCTYPE html>
<html>

<head>
    <title>CS215 Homepage</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="js/eventHandlers.js"></script>
</head>

<body>
    <div id="container">
        <header id="header-auth">
            <h1>My Login History</h1>
        </header>
        <main id="main-left">

        </main>
        <main id="main-center">
            <form action="" method="post" class="auth-form" id="login-form">
                <p class="input-field">
                    <label>Username</label>
                    <input type="text" id="username" name="username" />
                <p id="error-text-username" class="error-text hidden">Username is invalid</p>
                </p>
                <p class="input-field">
                    <label>Password</label>
                    <input type="password" id="password" name="password" />
                <p id="error-text-password" class="error-text hidden">Password is invalid</p>
                </p>
                <p class="input-field">
                    <input type="submit" class="form-submit" value="Login" />
                </p><br>
            </form>
            <div class="foot-note">
                <p>Don't have an account? <a href="signup.php">Signup</a></p>
            </div>
        </main>
        <main id="main-right">

        </main>
        <footer id="footer-auth">
            <p class="footer-text">CS 215: Lab 6 Solution</p>
        </footer>
    </div>
    <script src="js/eventRegisterLogin.js"></script>
</body>

</html>