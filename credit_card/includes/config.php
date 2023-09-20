<?php

$db = new mysqli('localhost', 'root', '', 'credit_card');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

 ?>
