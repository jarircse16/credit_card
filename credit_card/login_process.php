<?php
ini_set('display_errors', 0);
session_start();

require_once 'includes/db.php';
require_once 'includes/functions.php';

try {
    // Create a PDO instance
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set PDO to throw exceptions on errors
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the submitted username and password are valid
    $submittedUsername = $_POST['username'];
    $submittedPassword = $_POST['password'];

    // Prepare a SQL statement to fetch user credentials
    $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE username = ?");
    $stmt->execute([$submittedUsername]);
    $row = $stmt->fetch();

    if ($row) {
        // User found, check the password
        $hashedPassword = $row['password'];
        if (password_verify($submittedPassword, $hashedPassword)) {
            // Authentication successful
            $_SESSION['user_id'] = $row['user_id']; // Store user ID in the session
            $_SESSION['username'] = $row['username']; // Store username in the session
            header("Location: dashboard.php"); // Redirect to the dashboard or homepage
            exit();
        } else {
            // Invalid password
            echo "<script src=js/invalid_password.js></script>";
          //  echo "<center><h1>Invalid Password.</h1></center><br>";
          //  echo "<center><h1><a href='index.php'>Back to Login</a></h1></center>";
        }
    } else {
        // User not found
        echo "<script src=js/invalid_username.js></script>";
        //echo "<center><h1>Invalid Username.</h1></center><br>";
      //  echo "<center><h1><a href='index.php'>Back to Login</a></h1></center>";
    }
} catch (PDOException $e) {
    // Handle database connection or query errors
    echo "Error: " . $e->getMessage();
}
?>
