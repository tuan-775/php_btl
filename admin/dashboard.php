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
    <h1>Quản trị</h1>
    <header>
        <main class="container">
            <div class="container_path">
                <div class='container_path-row index'>
                    <a href="../index.php" class="back-btn">Quay lại Trang chủ</a>
                </div>
                <div class='container_path-row'>
                    <a href="manage_categories.php" class="menu-btn">Quản lý danh mục sản phẩm</a>
                </div>
                <div class='container_path-row'>
                    <a href="manage_subcategories.php" class="menu-btn">Quản lý loại sản phẩm</a>
                </div>
                <div class='container_path-row'>
                    <a href="product_list.php" class="menu-btn">Danh sách sản phẩm</a>
                </div>
                <div class='container_path-row'>
                    <a href="inventory.php" class="menu-btn">Thống kê tồn kho</a>
                </div>
                <div class='container_path-row'>
                    <a href="revenue.php" class="menu-btn">Quản lý doanh thu</a>
                </div>
                <div class='container_path-row'>
                    <a href="manage_users.php" class="menu-btn">Quản lý người dùng</a>
                </div>
                <div class='container_path-row'>
                    <a href="manage_orders.php" class="menu-btn">Quản lý đơn hàng</a>
                </div>
                <div class='container_path-row'>
                    <a href="News/manage_news.php" class="menu-btn">Quản lý tin tức</a>
                </div>
                <div class='container_path-row'>
                    <a href="feedback/manage_feedback.php" class="menu-btn">Quản lý góp ý</a>
                </div>
                <div class='container_path-row'>
                    <a href="Review/manage_reviews.php" class="menu-btn">Quản lý đánh giá</a>
                </div>
            </div>
        </main>
    </header>
</body>

</html>