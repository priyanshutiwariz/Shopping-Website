<?php
require_once 'db.php';
if (!($_SESSION['is_admin'] ?? false)) {
    header('Location: login.php'); exit;
}
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
        $stmt = $mysqli->prepare('INSERT INTO products (name, price, description, image, category) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('sdsss', $name, $price, $desc, $image_url, $category);
        if ($stmt->execute()) {
            $success = true;
        } else {
            $errors[] = 'Failed to add product.';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - TechStore Admin</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="admin-container">
        <h2>Add Product</h2>
        <?php if ($success): ?>
            <div class="success">Product added successfully!</div>
        <?php endif; ?>
        <?php if ($errors): ?>
            <div class="error"><?php foreach ($errors as $e) echo htmlspecialchars($e) . '<br>'; ?></div>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <input type="text" name="name" placeholder="Product Name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
            <input type="number" step="0.01" name="price" placeholder="Price" required value="<?= htmlspecialchars($_POST['price'] ?? '') ?>">
            <input type="text" name="category" placeholder="Category" required value="<?= htmlspecialchars($_POST['category'] ?? '') ?>">
            <input type="text" name="image" placeholder="Image URL (or upload later)" value="<?= htmlspecialchars($_POST['image'] ?? '') ?>">
            <textarea name="description" placeholder="Description" rows="3"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
            <button type="submit">Add Product</button>
        </form>
        <p><a href="admin.php">Back to Admin</a></p>
    </div>
</body>
</html>
