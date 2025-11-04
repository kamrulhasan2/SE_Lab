<?php
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/header.php';
$conn = db_connect();
?>
<h2>Add Product</h2>
<form method="post" action="save.php">
  <div><label>Name:<br><input name="name" required></label></div>
  <div><label>Price:<br><input name="price" required></label></div>
  <div><label>Stock:<br><input name="stock" required></label></div>
  <div><button type="submit">Save</button> <a href="index.php">Cancel</a></div>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>