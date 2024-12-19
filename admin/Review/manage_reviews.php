<?php
require '../../db.php';
session_start();

// Kiểm tra quyền admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Lấy tất cả các người dùng có role là "user" từ cơ sở dữ liệu
$stmt = $pdo->prepare("SELECT id, username FROM users WHERE role = 'user' ORDER BY username");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Xử lý hiển thị chi tiết đánh giá của người dùng
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

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
}

// Xử lý xóa đánh giá
if (isset($_GET['delete_review_id'])) {
    $review_id = $_GET['delete_review_id'];

    // Kiểm tra nếu review_id có giá trị hợp lệ
    if (isset($review_id) && is_numeric($review_id)) {
        // Xóa đánh giá từ bảng product_reviews
        $delete_stmt = $pdo->prepare("DELETE FROM product_reviews WHERE id = ?");
        $delete_stmt->execute([$review_id]);

        // Kiểm tra nếu xóa thành công
        if ($delete_stmt->rowCount() > 0) {
            // Nếu xóa thành công, chuyển hướng lại trang
            header("Location: manage_reviews.php");
            exit();
        } else {
            echo "<p style='color:red;'>Có lỗi khi xóa đánh giá. Vui lòng thử lại.</p>";
        }
    } else {
        echo "<p style='color:red;'>ID đánh giá không hợp lệ.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đánh giá</title>
    <link rel="stylesheet" href="../css/manage_review.css">
</head>
<body>
    <div class="admin-container">
        <h1>Quản lý đánh giá</h1>
        
        <?php if (!isset($reviews)): ?>
            <!-- Hiển thị danh sách người dùng nếu không có đánh giá -->
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID người dùng</th>
                        <th>Tên tài khoản</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td>
                                <!-- Nút xem chi tiết để xem các đánh giá của người dùng -->
                                <a href="manage_reviews.php?user_id=<?php echo $user['id']; ?>">Xem chi tiết</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif (empty($reviews)): ?>
            <!-- Nếu người dùng không có đánh giá nào -->
            <p>Người dùng chưa có đánh giá nào.</p>
        <?php else: ?>
            <!-- Nếu người dùng đã có đánh giá, hiển thị các đánh giá của người đó -->
            <h2>Đánh giá của người dùng <?php echo htmlspecialchars($users[array_search($user_id, array_column($users, 'id'))]['username']); ?></h2>
            
            <table class="admin-table">
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
                                <a href="manage_reviews.php?delete_review_id=<?php echo $review['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?')">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>>
</body>
</html>
