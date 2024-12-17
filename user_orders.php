<?php
require 'db.php';
session_start();

// Kiểm tra người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Truy vấn lấy các đơn hàng của người dùng
$stmt = $pdo->prepare("
    SELECT orders.id, orders.product_name, orders.quantity, orders.total_price, orders.status,
           orders.payment_method, orders.shipping_method, products.image, orders.created_at
    FROM orders
    JOIN products ON orders.product_id = products.id
    WHERE orders.user_id = ?
    ORDER BY orders.created_at DESC
");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng của tôi</title>
    <link rel="stylesheet" href="../css/user_orders.css">
</head>
<body>
    <h1>Đơn hàng của tôi</h1>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Hình ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Tổng giá</th>
            <th>Phương thức thanh toán</th>
            <th>Phương thức vận chuyển</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td>
                    <img src="../uploads/<?php echo htmlspecialchars($order['image']); ?>" width="50" height="50" alt="Ảnh sản phẩm">
                </td>
                <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                <td><?php echo $order['quantity']; ?></td>
                <td>₫<?php echo number_format($order['total_price'], 0, ',', '.'); ?></td>
                <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                <td><?php echo htmlspecialchars($order['shipping_method']); ?></td>
                <td><?php echo htmlspecialchars($order['status']); ?></td>
                <td>
                    <?php if ($order['status'] === 'Đã giao'): ?>
                        <form action="confirm_received.php" method="POST" style="display: inline;">
                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                            <button type="submit">Đã nhận hàng</button>
                        </form>
                    <?php elseif ($order['status'] === 'Đã nhận'): ?>
                        <!-- Không hiển thị nút hủy đơn hàng nếu đơn hàng đã nhận -->
                        <span>Đã nhận hàng</span>
                    <?php else: ?>
                        <form action="cancel_order.php" method="POST" style="display: inline;">
                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                            <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">Hủy đơn hàng</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
