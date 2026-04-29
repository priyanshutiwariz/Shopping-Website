<?php
require_once 'db.php';
$message = '';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $msg = trim($_POST['message'] ?? '');
    if (!$name || !$email || !$msg) {
        $errors[] = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address.';
    } elseif (strlen($msg) < 10) {
        $errors[] = 'Message must be at least 10 characters.';
    }
    if (!$errors) {
        $stmt = $mysqli->prepare('INSERT INTO messages (name, email, message) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $name, $email, $msg);
        if ($stmt->execute()) {
            $message = 'Thanks, we received your message!';
        } else {
            $errors[] = 'Error saving message.';
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
    <title>Contact - TechStore</title>
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
        <section class="contact-section">
            <h1>Contact Us</h1>
            <p>Have a question or need support? Get in touch with our team.</p>
            <div class="contact-content">
                <div class="contact-info">
                    <h3>Get in Touch</h3>
                    <p><strong>Email:</strong> support@techstore.com</p>
                    <p><strong>Phone:</strong> +1 (555) 123-4567</p>
                    <p><strong>Address:</strong> 123 Tech Street, Silicon Valley, CA 94000</p>
                    <p><strong>Hours:</strong> Mon-Fri 9AM-6PM PST</p>
                </div>
                <div class="contact-form">
                    <?php if ($message): ?>
                        <div class="success"><?= htmlspecialchars($message) ?></div>
                    <?php endif; ?>
                    <?php if ($errors): ?>
                        <div class="error"><?php foreach ($errors as $e) echo htmlspecialchars($e) . '<br>'; ?></div>
                    <?php endif; ?>
                    <form method="post" autocomplete="off">
                        <input type="text" name="name" placeholder="Your Name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                        <input type="email" name="email" placeholder="Your Email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                        <textarea name="message" placeholder="Your Message" rows="5" required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                        <button type="submit" class="btn-primary">Send Message</button>
                    </form>
                </div>
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
