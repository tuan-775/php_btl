<?php
require '../db.php';
session_start();

// Kiểm tra quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Bạn không có quyền truy cập.");
}

// Lấy danh sách người dùng có role "user"
$stmt_users = $pdo->prepare("SELECT id, username FROM users WHERE role = 'user' ORDER BY username");
$stmt_users->execute();
$users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Đơn Hàng</title>
    <link rel="stylesheet" href="./css/manage_orders.css">
</head>
<body>
    <h1>Quản lý Đơn Hàng</h1>
    <a class="dashboard" href="./dashboard.php">Quản trị</a>

    <!-- Hiển thị danh sách người dùng -->
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID Người Dùng</th>
            <th>Tên Tài Khoản</th>
            <th>Hành động</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td>
                    <!-- Chuyển đến trang hiển thị danh sách đơn hàng của người dùng -->
                    <a href="view_user_orders.php?user_id=<?php echo $user['id']; ?>">Xem chi tiết</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
