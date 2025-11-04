<?php
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/header.php';
$conn = db_connect();
$res = $conn->query('SELECT * FROM customers ORDER BY id DESC');
?>
<h2>Customers <a class="button" href="add.php">Add customer</a></h2>
<table>
  <thead><tr><th>ID</th><th>Name</th><th>Email</th></tr></thead>
  <tbody>
<?php while($row = $res->fetch_assoc()): ?>
  <tr>
    <td><?=htmlspecialchars($row['id'])?></td>
    <td><?=htmlspecialchars($row['name'])?></td>
    <td><?=htmlspecialchars($row['email'])?></td>
  </tr>
<?php endwhile; ?>
  </tbody>
</table>