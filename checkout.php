<?php
require_once 'db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); exit;
}
if (empty($_SESSION['cart'])) {
    header('Location: cart.php'); exit;
}

$errors = [];
$order_id = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    if (!$name || !$address || !$phone) {
        $errors[] = 'All fields are required.';
    }
    if (!$errors) {
        // Calculate total
        $ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));
        $res = $mysqli->query("SELECT id, price FROM products WHERE id IN ($ids)");
        $total = 0;
        $product_prices = [];
        while ($row = $res->fetch_assoc()) {
            $product_prices[$row['id']] = $row['price'];
            $total += $_SESSION['cart'][$row['id']] * $row['price'];
        }

        // Insert order
        $stmt = $mysqli->prepare('INSERT INTO orders (user_id, customer_name, address, phone, total) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('isssd', $_SESSION['user_id'], $name, $address, $phone, $total);
        if ($stmt->execute()) {
            $order_id = $stmt->insert_id;
            // Insert order items
            $stmt2 = $mysqli->prepare('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)');
            foreach ($_SESSION['cart'] as $pid => $qty) {
                $stmt2->bind_param('iiid', $order_id, $pid, $qty, $product_prices[$pid]);
                $stmt2->execute();
            }
            $stmt2->close();
            // Clear cart
            unset($_SESSION['cart']);
        } else {
            $errors[] = 'Order failed. Please try again.';
        }
        $stmt->close();
    }
}

// If order placed, show summary
if ($order_id) {
    $order = $mysqli->query("SELECT * FROM orders WHERE id = $order_id")->fetch_assoc();
    $items = $mysqli->query("SELECT oi.*, p.name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = $order_id");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - TechStore</title>
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
        <section class="checkout-section">
            <?php if ($order_id): ?>
                <h1>Order Confirmed!</h1>
                <div class="order-summary">
                    <h2>Order #<?= $order_id ?></h2>
                    <p><strong>Name:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
                    <p><strong>Address:</strong> <?= htmlspecialchars($order['address']) ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($order['phone']) ?></p>
                    <h3>Items:</h3>
                    <ul>
                        <?php while ($it = $items->fetch_assoc()): ?>
                            <li><?= htmlspecialchars($it['name']) ?> x<?= $it['quantity'] ?> - $<?= number_format($it['price'] * $it['quantity'], 2) ?></li>
                        <?php endwhile; ?>
                    </ul>
                    <p><strong>Total: $<?= number_format($order['total'], 2) ?></strong></p>
                    <p>Thank you for your order! We'll process it soon.</p>
                </div>
                <a href="products.php" class="btn-primary">Continue Shopping</a>
            <?php else: ?>
                <h1>Checkout</h1>
                <?php if ($errors): ?>
                    <div class="error"><?php foreach ($errors as $e) echo htmlspecialchars($e) . '<br>'; ?></div>
                <?php endif; ?>
                <form method="post" autocomplete="off">
                    <input type="text" name="name" placeholder="Full Name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                    <input type="text" name="address" placeholder="Address" required value="<?= htmlspecialchars($_POST['address'] ?? '') ?>">
                    <input type="tel" name="phone" placeholder="Phone Number" required value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                    <button type="submit" class="btn-primary">Place Order</button>
                </form>
                <a href="cart.php" class="btn-secondary">Back to Cart</a>
            <?php endif; ?>
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