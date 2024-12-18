<?php
require("../../db.php");
session_start();

// Kiểm tra quyền admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo "Bạn không có quyền truy cập trang này! <a href='login.php'>Đăng nhập</a>";
    exit();
}

// Kiểm tra ID tin tức cần xóa
if (!isset($_GET['id'])) {
    header("Location: manage_news.php");
    exit();
}

$id = (int)$_GET['id']; // Đảm bảo ID là số nguyên

try {
    // Lấy tin tức cần xóa từ cơ sở dữ liệu
    $sql = "SELECT * FROM news WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $news = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$news) {
        // Nếu không tìm thấy tin tức
        header("Location: manage_news.php?message=not_found");
        exit();
    }

    // Xóa hình ảnh nếu có
    if (!empty($news['image'])) {
        $image_path = "uploads/news/" . $news['image'];
        if (file_exists($image_path)) {
            unlink($image_path); // Xóa tệp hình ảnh
        }
    }

    // Xóa tin tức khỏi cơ sở dữ liệu
    $sql = "DELETE FROM news WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    // Chuyển hướng về trang quản lý tin tức với thông báo
    header("Location: manage_news.php?message=deleted");
    exit();
} catch (Exception $e) {
    echo "<p style='color: red;'>Có lỗi xảy ra: " . $e->getMessage() . "</p>";
    echo "<a href='manage_news.php'>Quay lại quản lý tin tức</a>";
    exit();
}
?>
