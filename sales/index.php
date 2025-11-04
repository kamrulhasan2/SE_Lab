<?php
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/header.php';
$conn = db_connect();
$res = $conn->query('SELECT s.*, c.name as customer_name FROM sales s LEFT JOIN customers c ON s.customer_id=c.id ORDER BY s.created_at DESC');
?>
<h2>Sales <a class="button" href="create.php">Create sale</a></h2>
<table>
  <thead><tr><th>ID</th><th>Customer</th><th>Total</th><th>Date</th></tr></thead>
  <tbody>
<?php while($row = $res->fetch_assoc()): ?>
  <tr>
    <td><?=htmlspecialchars($row['id'])?></td>
    <td><?=htmlspecialchars($row['customer_name'])?></td>
    <td><?=number_format($row['total'],2)?></td>
    <td><?=htmlspecialchars($row['created_at'])?></td>
  </tr>
<?php endwhile; ?>
  </tbody>
</table>