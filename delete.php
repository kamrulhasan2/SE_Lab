<?php
session_start();
if(!isset($_SESSION['user'])){
    header("location: index.php");
    exit();
}
$user = $_SESSION['user'];

if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    $conn = new mysqli("localhost", "root", "", "first_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("DELETE FROM list WHERE id = ? AND user = ?");
    $stmt->bind_param("is", $id, $user);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("location: home.php");
    exit();
} else {
    header("location: home.php");
    exit();
}
?>