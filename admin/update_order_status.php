<?php
require '../db.php';
session_start();

// Kiểm tra quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Bạn không có quyền truy cập.");
}

// Lấy dữ liệu từ form
$order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
$status = isset($_POST['status']) ? trim($_POST['status']) : '';

// Danh sách trạng thái hợp lệ
$valid_statuses = ['Chờ xử lý', 'Đang xử lý', 'Đã giao hàng', 'Đã giao', 'Đã hủy'];

if ($order_id > 0 && in_array($status, $valid_statuses)) {
    // Thực hiện cập nhật trạng thái
    $stmt = $pdo->prepare("UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?");
    $stmt->execute([$status, $order_id]);

    // Chuyển hướng về trang quản lý đơn hàng
    header("Location: manage_orders.php?message=success");
    exit();
}
?>
