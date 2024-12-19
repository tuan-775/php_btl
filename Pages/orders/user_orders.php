<?php
require '../../db.php';
session_start();

// Kiểm tra người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Truy vấn lấy danh sách đơn hàng
$stmt = $pdo->prepare("
    SELECT id, total_price, status, created_at 
    FROM orders 
    WHERE user_id = ? 
    ORDER BY created_at DESC
");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Xử lý xác nhận đã nhận hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_received'])) {
    $order_id = $_POST['order_id'];

    // Cập nhật trạng thái đơn hàng thành "Đã nhận"
    $stmt_update = $pdo->prepare("UPDATE orders SET status = 'Đã nhận' WHERE id = ? AND user_id = ?");
    $stmt_update->execute([$order_id, $user_id]);

    // Reload lại trang sau khi cập nhật
    header("Location: user_orders.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng của tôi</title>
    <link rel="stylesheet" href="../../css/user_orders1.css">
    <link rel="stylesheet" href="../../css/footer.css">
    <link rel="stylesheet" href="../../css/header.css">
</head>

<body>
    <?php include '../../header.php'; ?>
    <main>
        <div>
            <h1>Đơn hàng của tôi</h1>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <th>ID Đơn Hàng</th>
                    <th>Tổng giá</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['id']); ?></td>
                        <td>₫<?php echo number_format($order['total_price'], 0, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($order['status']); ?></td>
                        <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                        <td>
                            <?php if ($order['status'] === 'Đã giao'): ?>
                                <!-- Nút xác nhận đã nhận hàng -->
                                <form method="POST" action="">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <button type="submit" name="confirm_received">Xác nhận đã nhận hàng</button>
                                </form>
                            <?php elseif ($order['status'] === 'Đã nhận'): ?>
                                <!-- Nút chuyển đến chi tiết -->
                                <a href="order_details.php?order_id=<?php echo $order['id']; ?>">Xem chi tiết</a>
                            <?php else: ?>
                                <!-- Các trạng thái khác -->
                                <span><?php echo htmlspecialchars($order['status']); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>
    <?php include '../../footer.php'; ?>
</body>

</html>
