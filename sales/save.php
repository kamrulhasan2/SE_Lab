<?php
require_once __DIR__ . '/../includes/db.php';
$conn = db_connect();
$customer_id = isset($_POST['customer_id']) && $_POST['customer_id']!=='' ? (int)$_POST['customer_id'] : null;
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;

if ($product_id>0 && $qty>0) {
    // get product price and stock
    $stmt = $conn->prepare('SELECT price,stock FROM products WHERE id=?');
    $stmt->bind_param('i',$product_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $prod = $res->fetch_assoc();
    if (!$prod) {
        header('Location: create.php'); exit;
    }
    if ($prod['stock'] < $qty) {
        // not enough stock - simple behavior: limit qty to stock
        $qty = $prod['stock'];
    }
    $price = (float)$prod['price'];
    $total = $price * $qty;

    // start transaction
    $conn->begin_transaction();
    try {
        $stmt = $conn->prepare('INSERT INTO sales (customer_id,total) VALUES (?,?)');
        $stmt->bind_param('id',$customer_id,$total);
        $stmt->execute();
        $sale_id = $conn->insert_id;

        $stmt = $conn->prepare('INSERT INTO sale_items (sale_id,product_id,qty,price) VALUES (?,?,?,?)');
        $stmt->bind_param('iiid',$sale_id,$product_id,$qty,$price);
        $stmt->execute();

        // subtract stock
        $stmt = $conn->prepare('UPDATE products SET stock = stock - ? WHERE id = ?');
        $stmt->bind_param('ii',$qty,$product_id);
        $stmt->execute();

        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
    }
}
header('Location: index.php');
exit;
?>