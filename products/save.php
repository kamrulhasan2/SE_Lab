<?php
require_once __DIR__ . '/../includes/db.php';
$conn = db_connect();

$name = trim($_POST['name'] ?? '');
$price = (float)($_POST['price'] ?? 0);
$stock = (int)($_POST['stock'] ?? 0);

if ($name !== '') {
    $stmt = $conn->prepare('INSERT INTO products (name,price,stock) VALUES (?,?,?)');
    $stmt->bind_param('sdi', $name, $price, $stock);
    $stmt->execute();
}
header('Location: index.php');
exit;
?>