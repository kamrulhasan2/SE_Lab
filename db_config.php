<?php
// Database connection for Result System
$conn = new mysqli('localhost', 'root', '', 'result_db');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>