<?php
require '../../db.php';
session_start();

// Kiểm tra nếu người dùng đã gửi mã đơn hàng
$order = null;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = trim($_POST['order_id']);

    if (!empty($order_id)) {
        // Truy vấn lấy thông tin chi tiết đơn hàng dựa trên ID
        $stmt = $pdo->prepare("
            SELECT orders.id AS order_id, orders.user_name, orders.phone, orders.address, 
                   orders.total_price, orders.shipping_cost, orders.status, orders.created_at,
                   order_items.product_name, order_items.price, order_items.quantity
            FROM orders
            LEFT JOIN order_items ON orders.id = order_items.order_id
            WHERE orders.id = ?
        ");
        $stmt->execute([$order_id]);
        $order = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($order)) {
            $error_message = 'Không tìm thấy đơn hàng với mã này.';
        }
    } else {
        $error_message = 'Vui lòng nhập mã đơn hàng.';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tra cứu đơn hàng</title>
    <link rel="stylesheet" href="./css/track_order.css">
</head>

<body>
    <div class="container">
        <h1>Tra cứu đơn hàng</h1>
        <form method="POST" action="">
            <label for="order_id">Nhập mã đơn hàng:</label>
            <input type="text" id="order_id" name="order_id" placeholder="Nhập mã đơn hàng" required>
            <button type="submit">Tra cứu</button>
        </form>

        <!-- Hiển thị thông báo lỗi nếu có -->
        <?php if (!empty($error_message)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <!-- Hiển thị thông tin đơn hàng -->
        <?php if (!empty($order)): ?>
            <h2>Chi tiết đơn hàng #<?php echo htmlspecialchars($order[0]['order_id']); ?></h2>
            <p><strong>Tên khách hàng:</strong> <?php echo htmlspecialchars($order[0]['user_name']); ?></p>
            <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order[0]['phone']); ?></p>
            <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order[0]['address']); ?></p>
            <p><strong>Tổng tiền:</strong> ₫<?php echo number_format($order[0]['total_price'], 0, ',', '.'); ?></p>
            <p><strong>Phí vận chuyển:</strong> ₫<?php echo number_format($order[0]['shipping_cost'], 0, ',', '.'); ?></p>
            <p><strong>Trạng thái:</strong> <?php echo htmlspecialchars($order[0]['status']); ?></p>
            <p><strong>Ngày đặt hàng:</strong> <?php echo htmlspecialchars($order[0]['created_at']); ?></p>

            <h3>Sản phẩm trong đơn hàng:</h3>
            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td>₫<?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td>₫<?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>
