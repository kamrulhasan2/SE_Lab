<?php
require_once __DIR__ . '/../includes/db.php';
$conn = db_connect();
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
if ($name!==''){
    $stmt = $conn->prepare('INSERT INTO customers (name,email) VALUES (?,?)');
    $stmt->bind_param('ss',$name,$email);
    $stmt->execute();
}
header('Location: index.php');
exit;
?>