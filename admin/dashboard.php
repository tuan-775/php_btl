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
    <link rel="stylesheet" href="../css/view_admin.css">
</head>

<body>
    <header>
        <h1>Quản trị</h1>
    </header>
    <main>
        <!-- Nút Quay lại Trang chủ -->
        <a href="../index.php" class="back-btn">Quay lại Trang chủ</a>
        <a href="product_list.php" class="menu-btn">Danh sách sản phẩm</a>
        <a href="inventory.php" class="menu-btn">Thống kê tồn kho</a>
        <a href="revenue.php" class="menu-btn">Quản lý doanh thu</a>
        <a href="manage_users.php" class="menu-btn">Quản lý doanh thu</a>
    </main>
</body>

</html>