<?php
require("../../db.php");

// Kiểm tra ID tin tức
if (!isset($_GET['id'])) {
    echo "Tin tức không tồn tại.";
    exit();
}

$id = (int)$_GET['id']; // Đảm bảo ID là số nguyên

// Lấy thông tin chi tiết tin tức từ cơ sở dữ liệu
$sql = "SELECT title, content, image, category, post_date FROM news WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$news = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$news) {
    echo "Tin tức không tồn tại.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Tin Tức</title>
    <link rel="stylesheet" href="../../css/news_detail.css">
    <link rel="stylesheet" href="../../css/footer.css">
    <link rel="stylesheet" href="../../css/header.css">
</head>

<body>
    <?php include "../../header.php"; ?>
    <main>
        <div class="container">
            <h1><?php echo htmlspecialchars($news['title']); ?></h1>
            <p class="news-date">Ngày đăng: <?php echo htmlspecialchars($news['post_date']); ?></p>
            <p class="news-category">Danh mục: <?php echo htmlspecialchars($news['category']); ?></p>

            <?php if (!empty($news['image'])): ?>
                <img src="../../uploads/news/<?php echo htmlspecialchars($news['image']); ?>" alt="Hình ảnh tin tức" class="news-image">
            <?php endif; ?>

            <div class="news-content">
                <?php echo nl2br(htmlspecialchars($news['content'])); ?>
            </div>

            <a href="new_list.php" class="back-link">Quay lại danh sách tin tức</a>
        </div>
    </main>
    <?php include "../../footer.php"; ?>
</body>

</html>