<?php
session_start();
require '../db.php';

if (isset($_GET['cart_id'])) {
    $cart_id = $_GET['cart_id'];

    // Xóa sản phẩm khỏi giỏ hàng
    $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->execute([$cart_id]);

    // Quay lại trang giỏ hàng
    header("Location: cart.php");
    exit;
} else {
    die("ID giỏ hàng không hợp lệ.");
}
