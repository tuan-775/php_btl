<?php
require 'db.php';
session_start();

// Kiểm tra người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

// Kiểm tra xem có gửi thông tin đơn hàng không
if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Cập nhật trạng thái đơn hàng thành "Đã nhận"
    $stmt = $pdo->prepare("UPDATE orders SET status = 'Đã nhận' WHERE id = ? AND user_id = ?");
    $stmt->execute([$order_id, $_SESSION['user_id']]);

    // Chuyển hướng lại trang đơn hàng của người dùng
    header("Location: user_orders.php");
    exit();
} else {
    // Nếu không có thông tin đơn hàng, chuyển hướng về trang đơn hàng
    header("Location: user_orders.php");
    exit();
}
