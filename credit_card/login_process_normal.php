<?php
//ini_set('display_errors', 0);
session_start();

require_once 'db.php';
require_once 'functions.php';

// Include the brute force protection script
require_once 'bruteforce_protection.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submittedUsername = $_POST['username'];
    $submittedPassword = $_POST['password'];

    // Create a mysqli instance for database operations
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute a SQL statement to fetch user credentials
    $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $submittedUsername);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $username, $hashedPassword);
        $stmt->fetch();

        // Verify the submitted password against the hashed password
        if (password_verify($submittedPassword, $hashedPassword)) {
            // Authentication successful
            resetLoginAttempts(); // Reset login attempts on successful login
            $_SESSION['user_id'] = $user_id; // Store user ID in the session
            $_SESSION['username'] = $username; // Store username in the session
            header("Location: dashboard.php"); // Redirect to the dashboard or homepage
            exit();
        } else {
            // Invalid password
            logFailedAttempt(); // Log failed login attempt
            if ($_SESSION['login_attempts'] >= $maxAttempts) {
                setBlock(); // Set temporary block on further login attempts
            }
            echo "<script src=js/invalid_password.js></script>";
        }
    } else {
        // User not found
        logFailedAttempt(); // Log failed login attempt
        if ($_SESSION['login_attempts'] >= $maxAttempts) {
            setBlock(); // Set temporary block on further login attempts
        }
        echo "<script src=js/invalid_username.js></script>";
    }

    $stmt->close();
    $conn->close();
}
?>
<?php
//ini_set('display_errors', 0);
session_start();

require_once 'db.php';
require_once 'functions.php';

// Include the brute force protection script
require_once 'bruteforce_protection.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submittedUsername = $_POST['username'];
    $submittedPassword = $_POST['password'];

    // Create a mysqli instance for database operations
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute a SQL statement to fetch user credentials
    $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $submittedUsername);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $username, $hashedPassword);
        $stmt->fetch();

        // Verify the submitted password against the hashed password
        if (password_verify($submittedPassword, $hashedPassword)) {
            // Authentication successful
            resetLoginAttempts(); // Reset login attempts on successful login
            $_SESSION['user_id'] = $user_id; // Store user ID in the session
            $_SESSION['username'] = $username; // Store username in the session
            header("Location: dashboard.php"); // Redirect to the dashboard or homepage
            exit();
        } else {
            // Invalid password
            logFailedAttempt(); // Log failed login attempt
            if ($_SESSION['login_attempts'] >= $maxAttempts) {
                setBlock(); // Set temporary block on further login attempts
            }
            echo "<script src=js/invalid_password.js></script>";
        }
    } else {
        // User not found
        logFailedAttempt(); // Log failed login attempt
        if ($_SESSION['login_attempts'] >= $maxAttempts) {
            setBlock(); // Set temporary block on further login attempts
        }
        echo "<script src=js/invalid_username.js></script>";
    }

    $stmt->close();
    $conn->close();
}
?>
