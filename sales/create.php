<?php
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/header.php';
$conn = db_connect();
$products = $conn->query('SELECT * FROM products ORDER BY name');
$customers = $conn->query('SELECT * FROM customers ORDER BY name');
?>
<h2>Create Sale</h2>
<form method="post" action="save.php">
  <div class="form-row"><label>Customer:<br>
    <select name="customer_id">
      <option value="">(none)</option>
<?php while($c = $customers->fetch_assoc()): ?>
      <option value="<?=$c['id']?>"><?=htmlspecialchars($c['name'])?></option>
<?php endwhile; ?>
    </select>
  </label></div>
  <div class="form-row"><label>Product:<br>
    <select name="product_id">
<?php while($p = $products->fetch_assoc()): ?>
      <option value="<?=$p['id']?>" data-price="<?=$p['price']?>"><?=htmlspecialchars($p['name'])?> (<?=$p['stock']?> in stock) - $<?=number_format($p['price'],2)?></option>
<?php endwhile; ?>
    </select>
  </label></div>
  <div class="form-row"><label>Quantity:<br><input name="qty" value="1" required></label></div>
  <div><button class="button" type="submit">Create Sale</button> <a href="index.php">Cancel</a></div>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>