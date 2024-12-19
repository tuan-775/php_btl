<?php
require '../db.php';
session_start();

// Kiểm tra quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Bạn không có quyền truy cập.");
}

// Kiểm tra nếu có `user_id` trong URL
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Lấy thông tin người dùng
    $stmt_user = $pdo->prepare("SELECT fullname FROM users WHERE id = ?");
    $stmt_user->execute([$user_id]);
    $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Người dùng không tồn tại.");
    }

    // Lấy danh sách đơn hàng của người dùng
    $stmt_orders = $pdo->prepare("
        SELECT id, status, created_at 
        FROM orders 
        WHERE user_id = ?
        ORDER BY created_at DESC
    ");
    $stmt_orders->execute([$user_id]);
    $orders = $stmt_orders->fetchAll(PDO::FETCH_ASSOC);
} else {
    die("Không tìm thấy user_id.");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách đơn hàng</title>
    <link rel="stylesheet" href="./css/manage_orders.css">
</head>
<body>
    <h1>Danh sách đơn hàng</h1>
    <h2>Đơn hàng của người dùng <?php echo htmlspecialchars($user['fullname']); ?></h2>

    <?php if (!empty($orders)): ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>ID Đơn Hàng</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['id']); ?></td>
                    <td><?php echo htmlspecialchars($order['status']); ?></td>
                    <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                    <td>
                        <a href="view_order_details.php?order_id=<?php echo $order['id']; ?>">Xem chi tiết</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Người dùng này chưa có đơn hàng nào.</p>
    <?php endif; ?>
</body>
</html>
