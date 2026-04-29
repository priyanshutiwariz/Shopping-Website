<?php
require_once 'db.php';
$featured = $mysqli->query("SELECT id, name, price, image FROM products ORDER BY id DESC LIMIT 6");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechStore - Modern Tech Shopping</title>
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
        <section class="hero">
            <h1>Welcome to TechStore</h1>
            <p>Discover the latest in tech gadgets and accessories. Modern, fast, and secure shopping.</p>
            <a href="products.php" class="btn-primary">Shop Now</a>
        </section>

        <section class="featured">
            <h2>Featured Products</h2>
            <div class="product-grid">
                <?php while ($p = $featured->fetch_assoc()): ?>
                    <div class="product-card">
                        <img src="<?= htmlspecialchars($p['image'] ?: 'https://via.placeholder.com/300x200?text=No+Image') ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                        <h3><?= htmlspecialchars($p['name']) ?></h3>
                        <p class="price">$<?= number_format($p['price'], 2) ?></p>
                        <a href="products.php" class="btn-secondary">View Details</a>
                    </div>
                <?php endwhile; ?>
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
