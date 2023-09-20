<?php
// includes/functions.php
require_once 'db.php';
function register_user($conn, $username, $password, $cardNumber, $validityDate) {
    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare an SQL statement to insert user data into the 'users' table
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);

    // Execute the statement to insert user data
    $result = $stmt->execute();

    // Check if the user was successfully inserted into the 'users' table
    if ($result) {
        // Get the user_id of the inserted user
        $user_id = $stmt->insert_id;

        // Prepare an SQL statement to insert credit card data into the 'credit_cards' table
        $stmt = $conn->prepare("INSERT INTO credit_cards (user_id, card_number, valid_till) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $cardNumber, $validityDate);

        // Execute the statement to insert credit card data
        $result = $stmt->execute();

        return $result; // Return true if both user and credit card data were inserted successfully
    } else {
        return false; // Return false if user data insertion failed
    }
}


function login_user($conn, $username, $password) {
    // Retrieve the user's data from the database
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    // Check if the user exists and verify the password
    if ($user && password_verify($password, $user['password'])) {
        return $user; // User login successful
    } else {
        return null; // User login failed
    }
}
?>
