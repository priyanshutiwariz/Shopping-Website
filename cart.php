<?php
require_once 'db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); exit;
}

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $pid = (int)$_POST['product_id'];
    $qty = max(1, (int)$_POST['qty']);
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    if (isset($_SESSION['cart'][$pid])) $_SESSION['cart'][$pid] += $qty; else $_SESSION['cart'][$pid] = $qty;
    header('Location: cart.php'); exit;
}

// Handle update quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_qty'])) {
    $pid = (int)$_POST['update_qty'];
    $qty = max(0, (int)$_POST['qty']);
    if ($qty == 0) unset($_SESSION['cart'][$pid]);
    else $_SESSION['cart'][$pid] = $qty;
    header('Location: cart.php'); exit;
}

// Handle remove item
if (isset($_GET['remove'])) {
    $pid = (int)$_GET['remove'];
    unset($_SESSION['cart'][$pid]);
    header('Location: cart.php'); exit;
}

$items = [];
$total = 0;
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));
    $res = $mysqli->query("SELECT id, name, price, image FROM products WHERE id IN ($ids)");
    while ($row = $res->fetch_assoc()) {
        $row['qty'] = $_SESSION['cart'][$row['id']];
        $row['subtotal'] = $row['qty'] * $row['price'];
        $total += $row['subtotal'];
        $items[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - TechStore</title>
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
                <a href="cart.php">Cart</a>
                <?php if ($_SESSION['is_admin']): ?><a href="admin.php">Admin</a><?php endif; ?>
                <a href="logout.php">Logout</a>
            </nav>
            <button id="theme-toggle" class="theme-toggle">🌙</button>
        </div>
    </header>

    <main>
        <section class="cart-section">
            <h1>Your Shopping Cart</h1>
            <?php if (empty($items)): ?>
                <p>Your cart is empty. <a href="products.php">Start shopping</a></p>
            <?php else: ?>
                <div class="cart-items">
                    <?php foreach ($items as $it): ?>
                        <div class="cart-item">
                            <img src="<?= htmlspecialchars($it['image'] ?: 'https://via.placeholder.com/100x100?text=No+Image') ?>" alt="<?= htmlspecialchars($it['name']) ?>">
                            <div class="item-details">
                                <h3><?= htmlspecialchars($it['name']) ?></h3>
                                <p>$<?= number_format($it['price'], 2) ?> each</p>
                                <form method="post" class="qty-form">
                                    <input type="hidden" name="update_qty" value="<?= $it['id'] ?>">
                                    <input type="number" name="qty" value="<?= $it['qty'] ?>" min="0" max="99">
                                    <button type="submit">Update</button>
                                </form>
                                <a href="?remove=<?= $it['id'] ?>" class="remove-link">Remove</a>
                            </div>
                            <div class="item-total">
                                <p>$<?= number_format($it['subtotal'], 2) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="cart-summary">
                    <h2>Total: $<?= number_format($total, 2) ?></h2>
                    <a href="checkout.php" class="btn-primary">Proceed to Checkout</a>
                </div>
            <?php endif; ?>
            <a href="products.php" class="btn-secondary">Continue Shopping</a>
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
                <a href="cart.php">Cart</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <p>&copy; 2026 TechStore. All rights reserved.</p>
    </footer>

    <script src="assets/script.js"></script>
</body>
</html>
