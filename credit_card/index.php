<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login or Signup</title>
</head>
<body>
    <?php
    // Check if the user is logged in
    session_start();
    if (isset($_SESSION['user_id'])) {
        // User is logged in, display the dashboard
        //require_once('dashboard.php');
        echo '<script>alert("You are logged in!");</script>';
        echo '<script src="js/welcome.js"></script>';
    } else {
        // User is not logged in, show login and signup forms
        echo('<h1>Welcome to Credit Card System</h1>');
        require_once('login.php');
        require_once('signup.php');
    }
    ?>
</body>
</html>
