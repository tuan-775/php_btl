<?php
require '../../db.php';
session_start();

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Lấy ID người dùng từ session

// Lấy tất cả các đánh giá của người dùng này
$stmt_reviews = $pdo->prepare("
    SELECT product_reviews.*, products.name AS product_name 
    FROM product_reviews 
    JOIN products ON product_reviews.product_id = products.id 
    WHERE product_reviews.user_id = ?
    ORDER BY product_reviews.created_at DESC
");
$stmt_reviews->execute([$user_id]);
$reviews = $stmt_reviews->fetchAll(PDO::FETCH_ASSOC);

// Xử lý sửa đánh giá
if (isset($_POST['update_review'])) {
    $review_id = $_POST['review_id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    // Cập nhật đánh giá trong cơ sở dữ liệu
    $update_stmt = $pdo->prepare("UPDATE product_reviews SET rating = ?, review = ? WHERE id = ? AND user_id = ?");
    $update_stmt->execute([$rating, $review, $review_id, $user_id]);

    // Chuyển hướng lại trang sau khi cập nhật
    header("Location: history_reviews.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử đánh giá</title>
    <link rel="stylesheet" href="../../css/footer.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/history_reviews.css">
</head>

<body>
    <?php //include '../../header.php'; 
    ?>

    <main>
        <div class="container">
            <h1>Lịch sử đánh giá</h1>
            <a href="/php_btl/index.php">Quay về Trang chủ</a>

            <?php if (empty($reviews)): ?>
                <p>Bạn chưa có đánh giá nào.</p>
            <?php else: ?>
                <!-- Hiển thị danh sách các đánh giá -->
                <table class="reviews-table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đánh giá</th>
                            <th>Nhận xét</th>
                            <th>Ngày đánh giá</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reviews as $review): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($review['product_name']); ?></td>
                                <td><?php echo $review['rating']; ?>/5 sao</td>
                                <td><?php echo nl2br(htmlspecialchars($review['review'])); ?></td>
                                <td><?php echo date("d/m/Y H:i:s", strtotime($review['created_at'])); ?></td>
                                <td>
                                    <!-- Nút sửa đánh giá -->
                                    <a href="history_reviews.php?edit_review_id=<?php echo $review['id']; ?>">Sửa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <?php if (isset($_GET['edit_review_id'])):
                $edit_review_id = $_GET['edit_review_id'];

                // Truy vấn đánh giá để hiển thị thông tin
                $stmt_edit = $pdo->prepare("SELECT * FROM product_reviews WHERE id = ? AND user_id = ?");
                $stmt_edit->execute([$edit_review_id, $user_id]);
                $review_to_edit = $stmt_edit->fetch(PDO::FETCH_ASSOC);
            ?>

                <h2>Sửa đánh giá</h2>
                <form method="POST" action="">
                    <input type="hidden" name="review_id" value="<?php echo $review_to_edit['id']; ?>">

                    <label for="rating">Đánh giá (1-5 sao):</label><br>
                    <input type="number" name="rating" id="rating" min="1" max="5" value="<?php echo $review_to_edit['rating']; ?>" required><br><br>

                    <label for="review">Nhận xét:</label><br>
                    <textarea name="review" id="review" rows="5" required><?php echo htmlspecialchars($review_to_edit['review']); ?></textarea><br><br>

                    <button type="submit" name="update_review">Cập nhật đánh giá</button>
                </form>
            <?php endif; ?>
        </div>
    </main>

    <?php //include '../../footer.php'; 
    ?>
</body>

</html>