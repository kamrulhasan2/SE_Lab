<?php
// db_config.php

// Database Credentials (Standard XAMPP Defaults)
$servername = "localhost";
$username = "root";  // Must be correct
$password = "";      // **If you set a password for 'root', put it here. Otherwise, leave it blank.**
$dbname = "simple_booking_db"; // Must match the database name exactly

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Stop execution and display connection error
    die("Connection failed: " . $conn->connect_error);
}
?>