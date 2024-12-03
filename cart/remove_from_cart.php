<?php
require '../db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id > 0) {
    // Xóa sản phẩm khỏi giỏ hàng
    $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
}

// Quay lại giỏ hàng
header("Location: cart.php");
exit;
?>
