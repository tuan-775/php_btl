<?php
session_start();
require 'db.php';

// Kiểm tra người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Lấy lịch sử mua hàng từ cơ sở dữ liệu
$stmt = $pdo->prepare(
    "SELECT orders.id AS order_id, orders.product_name, orders.quantity, 
            orders.price, orders.total_price, orders.shipping_cost, orders.created_at 
     FROM orders 
     WHERE user_id = ? 
     ORDER BY orders.created_at DESC"
);
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử mua hàng</title>
    <link rel="stylesheet" href="./css/purchase_history.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="order-history-container">
            <h1>Lịch sử mua hàng</h1>

            <?php if (empty($orders)): ?>
                <p>Bạn chưa có đơn hàng nào.</p>
            <?php else: ?>
                <table class="order-history-table">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Phí vận chuyển</th>
                            <th>Tổng tiền</th>
                            <th>Ngày mua</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                                <td><?php echo number_format($order['price'], 0, ',', '.'); ?> VND</td>
                                <td><?php echo number_format($order['shipping_cost'], 0, ',', '.'); ?> VND</td>
                                <td><?php echo number_format($order['total_price'], 0, ',', '.'); ?> VND</td>
                                <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <div class="btn-backhome">
                <a href="index.php" class="back-btn">Quay lại Trang chủ</a>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>