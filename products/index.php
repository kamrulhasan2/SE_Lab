<?php
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/header.php';
$conn = db_connect();

$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<h2>Products <a class="button" href="add.php">Add product</a></h2>
<table>
  <thead><tr><th>ID</th><th>Name</th><th>Price</th><th>Stock</th><th>Actions</th></tr></thead>
  <tbody>
<?php while($row = $result->fetch_assoc()): ?>
  <tr>
    <td><?=htmlspecialchars($row['id'])?></td>
    <td><?=htmlspecialchars($row['name'])?></td>
    <td><?=number_format($row['price'],2)?></td>
    <td><?=htmlspecialchars($row['stock'])?></td>
    <td>
      <!-- minimal: only show product (no edit/delete) -->
      -
    </td>
  </tr>
<?php endwhile; ?>
  </tbody>
</table>