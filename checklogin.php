<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "first_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $username;
            header("location: home.php");
        } else {
            Print '<script>alert("Incorrect Password!");</script>';
            Print '<script>window.location.assign("login.php");</script>';
        }
    } else {
        Print '<script>alert("Incorrect username!");</script>';
        Print '<script>window.location.assign("login.php");</script>';
    }

    $stmt->close();
    $conn->close();
}
?>