<?php
require("../../db.php");

// Truy vấn danh sách tin tức từ cơ sở dữ liệu
$sql = "SELECT id, title, image, category, post_date FROM news ORDER BY post_date DESC";
$stmt = $pdo->query($sql);
$news_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Tin Tức</title>
    <link rel="stylesheet" href="../../css/new_list.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/footer.css">
</head>
<body>
    <?php include "../../header.php";?>
    <div class="container">
        <h1>Danh Sách Tin Tức</h1>
        <?php if (count($news_list) > 0): ?>
            <div class="news-grid">
                <?php foreach ($news_list as $news): ?>
                    <div class="news-item">
                        <!-- Hình ảnh -->
                        <?php if (!empty($news['image'])): ?>
                            <img src="../../uploads/news/<?php echo htmlspecialchars($news['image']); ?>" alt="Hình ảnh tin tức" class="news-image">
                        <?php else: ?>
                            <img src="../../uploads/news/default.jpg" alt="Hình ảnh mặc định" class="news-image">
                        <?php endif; ?>

                        <!-- Tiêu đề -->
                        <h2 class="news-title"><?php echo htmlspecialchars($news['title']); ?></h2>

                        <!-- Danh mục -->
                        <p class="news-category">Danh mục: <?php echo htmlspecialchars($news['category']); ?></p>

                        <!-- Ngày đăng -->
                        <p class="news-date">Ngày đăng: <?php echo htmlspecialchars($news['post_date']); ?></p>

                        <!-- Chi tiết tin tức -->
                        <a href="news_detail.php?id=<?php echo $news['id']; ?>" class="news-link">Xem chi tiết</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Hiện tại không có tin tức nào để hiển thị.</p>
        <?php endif; ?>
    </div>
    <?php include "../../footer.php";?>
</body>
</html>