<?php
require("../../db.php");
session_start();

// Kiểm tra quyền admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo "Bạn không có quyền truy cập trang này! <a href='../login.php'>Đăng nhập</a>";
    exit();
}

// Hiển thị thông báo sau khi xóa hoặc không tìm thấy tin tức
if (isset($_GET['message'])) {
    if ($_GET['message'] == 'deleted') {
        echo "<p style='color: green;'>Tin tức đã được xóa thành công.</p>";
    } elseif ($_GET['message'] == 'not_found') {
        echo "<p style='color: red;'>Tin tức không tồn tại.</p>";
    }
}

// Truy vấn danh sách tin tức
$sql = "SELECT id, content, title, category, image, post_date FROM news ORDER BY post_date DESC";
$stmt = $pdo->query($sql);
$news_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Tin Tức</title>
    <link rel="stylesheet" href="../css/inventory.css">
</head>

<body>
    <main>
        <div class="container">
            <h1>Quản Lý Tin Tức</h1>
            <a href="../dashboard.php" class="btn btn-primary">Quay lại trang quản trị</a>
            <!-- Thêm tin tức -->
            <br>
            <br>
            <a href="add_news.php" class="btn btn-primary">Thêm Tin Tức</a>

            <hr>

            <!-- Danh sách tin tức -->
            <h3>Danh Sách Tin Tức</h3>
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tiêu Đề</th>
                        <th>Nội dung</th>
                        <th>Danh Mục</th>
                        <th>Hình Ảnh</th>
                        <th>Ngày Đăng</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($news_list as $news): ?>
                        <tr>
                            <td><?php echo $news['id']; ?></td>
                            <td><?php echo htmlspecialchars($news['title']); ?></td>
                            <td><?php echo htmlspecialchars($news['content']); ?></td>
                            <td><?php echo htmlspecialchars($news['category']); ?></td>
                            <td>
                                <?php if (!empty($news['image'])): ?>
                                    <img src="../../uploads/news/<?php echo $news['image']; ?>" alt="Hình ảnh" width="100">
                                <?php else: ?>
                                    Không có hình ảnh
                                <?php endif; ?>
                            </td>
                            <td><?php echo $news['post_date']; ?></td>
                            <td>
                                <a href="edit_news.php?id=<?php echo $news['id']; ?>">Sửa</a> |
                                <a href="delete_news.php?id=<?php echo $news['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa tin tức này?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>