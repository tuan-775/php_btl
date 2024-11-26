<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập.";
    exit;
}

require '../db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "Sản phẩm không tồn tại.";
    exit;
}

// Xóa sản phẩm
$stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
$stmt->execute([$id]);

echo "Xóa sản phẩm thành công!";
header("Location: dashboard.php");
exit;
?>
