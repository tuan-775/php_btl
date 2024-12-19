<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập.";
    exit;
}

require '../db.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị</title>
    <link rel="stylesheet" href="./css/view_admin.css">
</head>

<body>
    <header>
        <h1>Quản trị</h1>
        <main>
            <div>
                <a href="../index.php" class="back-btn">Quay lại Trang chủ</a>
            </div>
            <div>
                <a href="product_list.php" class="menu-btn">Danh sách sản phẩm</a>
            </div>
            <div>
                <a href="inventory.php" class="menu-btn">Thống kê tồn kho</a>
            </div>
            <div>
                <a href="revenue.php" class="menu-btn">Quản lý doanh thu</a>
            </div>
            <div>
                <a href="manage_users.php" class="menu-btn">Quản lý người dùng</a>
            </div>
            <div>
                <a href="manage_orders.php" class="menu-btn">Quản lý đơn hàng</a>
            </div>
            <div>
                <a href="News/manage_news.php" class="menu-btn">Quản lý tin tức</a>
            </div>
            <div>
                <a href="feedback/manage_feedback.php" class="menu-btn">Quản lý góp ý</a>
            </div>
            <div>
                <a href="Review/manage_reviews.php" class="menu-btn">Quản lý đánh giá</a>
            </div>
        </main>
    </header>
</body>

</html>