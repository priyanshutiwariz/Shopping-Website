<?php
require_once 'db.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!$username || !$password) {
        $errors[] = 'All fields are required.';
    } else {
        $stmt = $mysqli->prepare('SELECT id, username, password, is_admin FROM users WHERE username = ? OR email = ?');
        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $user, $hash, $is_admin);
            $stmt->fetch();
            if (password_verify($password, $hash)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $user;
                $_SESSION['is_admin'] = $is_admin;
                header('Location: index.php');
                exit;
            } else {
                $errors[] = 'Invalid credentials.';
            }
        } else {
            $errors[] = 'Invalid credentials.';
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
    <title>Login - TechStore</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="auth-container">
        <h2>Sign In</h2>
        <?php if ($errors): ?>
            <div class="error">
                <?php foreach ($errors as $e) echo htmlspecialchars($e) . '<br>'; ?>
            </div>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <input type="text" name="username" placeholder="Username or Email" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>
