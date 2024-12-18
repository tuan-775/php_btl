<?php
require("../../db.php");
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo "Bạn không có quyền truy cập trang này! <a href='../login.php'>Đăng nhập</a>";
    exit();
}

if (isset($_POST['add_news'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $image = '';

    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../../uploads/news/";
        $image = basename($_FILES['image']['name']);
        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    }

    if (!empty($title) && !empty($content)) {
        $sql = "INSERT INTO news (title, content, image, category) VALUES (:title, :content, :image, :category)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':image' => $image,
            ':category' => $category,
        ]);
        header("Location: manage_news.php");
        exit();
    } else {
        echo "<p style='color: red;'>Vui lòng điền đầy đủ thông tin.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Tin Tức</title>
</head>
<body>
    <div class="container">
        <h1>Thêm Tin Tức</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="title">Tiêu đề:</label><br>
            <input type="text" name="title" id="title" required><br>
            <label for="content">Nội dung:</label><br>
            <textarea name="content" id="content" rows="5" required></textarea><br>
            <label for="category">Danh mục:</label><br>
            <input type="text" name="category" id="category" required><br>
            <label for="image">Hình ảnh:</label><br>
            <input type="file" name="image" id="image" accept="image/*"><br><br>
            <button type="submit" name="add_news">Thêm Tin Tức</button>
        </form>
        <a href="admin_manage_news.php">Quay lại quản lý tin tức</a>
    </div>
</body>
</html>
