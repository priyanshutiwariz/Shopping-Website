<?php
require_once 'db.php';
if (!($_SESSION['is_admin'] ?? false)) {
    header('Location: login.php'); exit;
}
if (!isset($_GET['id'])) { header('Location: admin.php'); exit; }
$id = (int)$_GET['id'];
$stmt = $mysqli->prepare('DELETE FROM products WHERE id=?');
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->close();
header('Location: admin.php');
exit;
?>
