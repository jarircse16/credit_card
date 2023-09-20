<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cardNumber = $_POST['card_number']; // Add input field for card number
    $validityDate = $_POST['validity_date']; // Add input field for validity date

    // Register the user and their credit card details
    $result = register_user($conn, $username, $password, $cardNumber, $validityDate);

    if ($result) {
        // Registration successful
        echo '<script src=js/signup_success.js></script>';
        //header("Location: index.php"); // Redirect to login page
    } else {
        // Registration failed
        echo '<script src=js/signup_failed.js></script>';
        echo "Registration failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Include your CSS styles here -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/hover.css">
</head>
<body>
    <center><h2>Sign Up</h2>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>
        <label for="card_number">Card Number:</label>
        <input type="text" name="card_number" required><br><br> <!-- Add input field for card number -->
        <label for="validity_date">Validity Date:</label>
        <input type="text" name="validity_date" required><br><br> <!-- Add input field for validity date -->

        <button type="submit" value="Sign Up" class="hover-button">Sign Up</button>
    </form></center>
</body>
</html>
