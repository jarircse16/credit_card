<?php
$servername = "sql207.byethost17.com"; // Replace with your MySQL server name
$username = "b17_34928775"; // Replace with your MySQL username
$password = "xD123@xD"; // Replace with your MySQL password
$dbname = "b17_34928775_credit_card"; // Replace with your database name

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
