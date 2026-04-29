<?php
require_once 'db.php';
$search = trim($_GET['search'] ?? '');
$category = trim($_GET['category'] ?? '');
$query = "SELECT id, name, price, image, description, category FROM products WHERE 1";
$params = [];
$types = '';
if ($search) {
    $query .= " AND (name LIKE ? OR description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types .= 'ss';
}
if ($category) {
    $query .= " AND category = ?";
    $params[] = $category;
    $types .= 's';
}
$query .= " ORDER BY id DESC";
$stmt = $mysqli->prepare($query);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Get categories
$categories = $mysqli->query("SELECT DISTINCT category FROM products ORDER BY category");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - TechStore</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,600&display=swap" rel="stylesheet">
</head>
<body>
    <header class="navbar">
        <div class="nav-container">
            <div class="logo">TechStore</div>
            <nav>
                <a href="index.php">Home</a>
                <a href="products.php">Products</a>
                <a href="about.php">About</a>
                <a href="contact.php">Contact</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="cart.php">Cart</a>
                    <?php if ($_SESSION['is_admin']): ?><a href="admin.php">Admin</a><?php endif; ?>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="register.php">Register</a>
                <?php endif; ?>
            </nav>
            <button id="theme-toggle" class="theme-toggle">🌙</button>
        </div>
    </header>

    <main>
        <section class="products-section">
            <h1>Our Products</h1>
            <div class="filters">
                <form method="get" class="search-form">
                    <input type="text" name="search" placeholder="Search products..." value="<?= htmlspecialchars($search) ?>">
                    <select name="category">
                        <option value="">All Categories</option>
                        <?php while ($cat = $categories->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($cat['category']) ?>" <?= $category === $cat['category'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['category']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <button type="submit">Search</button>
                </form>
            </div>
            <div class="product-grid">
                <?php if ($products): ?>
                    <?php foreach ($products as $p): ?>
                        <div class="product-card">
                            <img src="<?= htmlspecialchars($p['image'] ?: 'https://via.placeholder.com/300x200?text=No+Image') ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                            <h3><?= htmlspecialchars($p['name']) ?></h3>
                            <p class="description"><?= htmlspecialchars(substr($p['description'], 0, 100)) ?>...</p>
                            <p class="price">$<?= number_format($p['price'], 2) ?></p>
                            <form method="post" action="cart.php" class="add-to-cart-form">
                                <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                <input type="number" name="qty" value="1" min="1" max="99">
                                <button type="submit" class="btn-secondary">Add to Cart</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No products found.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>TechStore</h4>
                <p>Your go-to for modern tech.</p>
            </div>
            <div class="footer-section">
                <h4>Links</h4>
                <a href="products.php">Products</a>
                <a href="about.php">About</a>
                <a href="contact.php">Contact</a>
            </div>
            <div class="footer-section">
                <h4>Account</h4>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="cart.php">Cart</a>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="register.php">Register</a>
                <?php endif; ?>
            </div>
        </div>
        <p>&copy; 2026 TechStore. All rights reserved.</p>
    </footer>

    <script src="assets/script.js"></script>
</body>
</html>
