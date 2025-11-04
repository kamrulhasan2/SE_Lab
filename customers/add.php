<?php
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/header.php';
$conn = db_connect();
?>
<h2>Add Customer</h2>
<form method="post" action="save.php">
  <div class="form-row"><label>Name:<br><input name="name" required></label></div>
  <div class="form-row"><label>Email:<br><input name="email"></label></div>
  <div><button class="button" type="submit">Save</button> <a href="index.php">Cancel</a></div>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>