<?php
require_once 'db.php';
if (!($_SESSION['is_admin'] ?? false)) {
  header('Location: login.php'); exit;
}
if (!isset($_GET['id'])) { header('Location: admin.php'); exit; }
$id = (int)$_GET['id'];
$errors = [];
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  $price = floatval($_POST['price'] ?? 0);
  $desc = trim($_POST['description'] ?? '');
  $category = trim($_POST['category'] ?? '');
  $image_url = trim($_POST['image'] ?? '');
  if (!$name || !$price || !$category) {
    $errors[] = 'Name, price, and category are required.';
  }
  if (!$errors) {
    $stmt = $mysqli->prepare('UPDATE products SET name=?, price=?, description=?, image=?, category=? WHERE id=?');
    $stmt->bind_param('sdsssi', $name, $price, $desc, $image_url, $category, $id);
    if ($stmt->execute()) {
      $success = true;
    } else {
      $errors[] = 'Failed to update product.';
    }
    $stmt->close();
  }
}
$stmt = $mysqli->prepare('SELECT * FROM products WHERE id=?');
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$p = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Product - TechStore Admin</title>
  <link rel="stylesheet" href="assets/style.css">
  <link href="https://fonts.googleapis.com/css?family=Inter:400,600&display=swap" rel="stylesheet">
</head>
<body>
  <div class="admin-container">
    <h2>Edit Product</h2>
    <?php if ($success): ?>
      <div class="success">Product updated successfully!</div>
    <?php endif; ?>
    <?php if ($errors): ?>
      <div class="error"><?php foreach ($errors as $e) echo htmlspecialchars($e) . '<br>'; ?></div>
    <?php endif; ?>
    <form method="post" autocomplete="off">
      <input type="text" name="name" placeholder="Product Name" required value="<?= htmlspecialchars($p['name'] ?? '') ?>">
      <input type="number" step="0.01" name="price" placeholder="Price" required value="<?= htmlspecialchars($p['price'] ?? '') ?>">
      <input type="text" name="category" placeholder="Category" required value="<?= htmlspecialchars($p['category'] ?? '') ?>">
      <input type="text" name="image" placeholder="Image URL (or upload later)" value="<?= htmlspecialchars($p['image'] ?? '') ?>">
      <textarea name="description" placeholder="Description" rows="3"><?= htmlspecialchars($p['description'] ?? '') ?></textarea>
      <button type="submit">Save Changes</button>
    </form>
    <p><a href="admin.php">Back to Admin</a></p>
  </div>
</body>
</html>
