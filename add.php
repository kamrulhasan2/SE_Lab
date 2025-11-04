<?php
session_start();
if(!isset($_SESSION['user'])){
    header("location:index.php");
}
$user = $_SESSION['user'];
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $details = $_POST['details'];
    $public = "no";
    if(isset($_POST['public'])){
        $public = "yes";
    }
    $conn = new mysqli("localhost", "root", "", "first_db");
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("INSERT INTO list (details, user, public, date_posted, time_posted) VALUES (?, ?, ?, CURDATE(), CURTIME())");
    $stmt->bind_param("sss", $details, $user, $public);
    if($stmt->execute()){
        header("location:home.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>