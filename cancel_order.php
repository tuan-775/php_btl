<?php
require 'db.php';
session_start();

// Kiểm tra người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;

if ($order_id > 0) {
    $stmt = $pdo->prepare("UPDATE orders SET status = 'Đã hủy', updated_at = NOW() WHERE id = ? AND user_id = ? AND status != 'Đã giao'");
    $stmt->execute([$order_id, $_SESSION['user_id']]);
}

header("Location: user_orders.php");
exit();
?>
