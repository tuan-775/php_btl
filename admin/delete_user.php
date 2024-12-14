<?php
require '../db.php';
session_start();

// Kiểm tra quyền admin
if ($_SESSION['role'] !== 'admin') {
    exit("Bạn không có quyền truy cập.");
}

// Lấy giá trị `delete_user_id` từ URL
$user_id = $_GET['delete_user_id'] ?? null;

// Kiểm tra nếu `delete_user_id` không tồn tại hoặc không hợp lệ
if (!$user_id || !filter_var($user_id, FILTER_VALIDATE_INT)) {
    exit("ID người dùng không hợp lệ.");
}

try {
    $pdo->beginTransaction();

    // Kiểm tra xem người dùng có tồn tại không
    $stmt = $pdo->prepare("SELECT id FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    if (!$stmt->fetch()) {
        throw new Exception("Người dùng không tồn tại.");
    }

    // Xóa bản ghi trong bảng user_profiles
    $pdo->prepare("DELETE FROM user_profiles WHERE user_id = ?")->execute([$user_id]);

    // Xóa bản ghi trong bảng users
    $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$user_id]);

    $pdo->commit();
    header("Location: manage_users.php?message=delete_success");
} catch (Exception $e) {
    $pdo->rollBack();
    exit("Lỗi khi xóa người dùng: " . $e->getMessage());
}
