<?php
session_start();

// Define the maximum number of allowed login attempts
$maxAttempts = 10;

// Check if the user session for login attempts exists
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = [];
}

// Function to log failed login attempts
function logFailedAttempt() {
    $userIP = $_SERVER['REMOTE_ADDR'];
    if (!isset($_SESSION['login_attempts'][$userIP])) {
        $_SESSION['login_attempts'][$userIP] = 1;
    } else {
        $_SESSION['login_attempts'][$userIP]++;
    }
}

// Function to check if the user is temporarily blocked
function isBlocked() {
    $userIP = $_SERVER['REMOTE_ADDR'];
    if (isset($_SESSION['login_attempts'][$userIP]) && $_SESSION['login_attempts'][$userIP] >= $maxAttempts) {
        return true;
    }
    return false;
}

// Function to reset login attempts after a successful login
function resetLoginAttempts() {
    $userIP = $_SERVER['REMOTE_ADDR'];
    if (isset($_SESSION['login_attempts'][$userIP])) {
        unset($_SESSION['login_attempts'][$userIP]);
    }
}

// Check if the user is temporarily blocked
if (isBlocked()) {
    echo "<script>alert('Login temporarily blocked due to multiple failed attempts. Please try again later.');</script>";
    header("Location: index.php"); // Redirect to the login page or display an error message
    exit();
}

// Include this file at the beginning of login_process.php
