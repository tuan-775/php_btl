<?php
require '../db.php';
session_start();

// Kiểm tra quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Bạn không có quyền truy cập.");
}

// Lấy danh sách đơn hàng
$stmt = $pdo->prepare("SELECT * FROM orders ORDER BY created_at DESC");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="../css/manage_orders.css">
</head>
<body>
    <h1>Quản lý Đơn Hàng</h1>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Tên khách hàng</th>
            <th>SĐT</th>
            <th>Địa chỉ</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Tổng tiền</th>
            <th>Phương thức thanh toán</th>
            <th>Phương thức vận chuyển</th>
            <th>Trạng thái</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo htmlspecialchars($order['id']); ?></td>
                <td><?php echo htmlspecialchars($order['user_name']); ?></td>
                <td><?php echo htmlspecialchars($order['phone']); ?></td>
                <td><?php echo htmlspecialchars($order['address']); ?></td>
                <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                <td>₫<?php echo number_format($order['price'], 0, ',', '.'); ?></td>
                <td><?php echo $order['quantity']; ?></td>
                <td>₫<?php echo number_format($order['total_price'], 0, ',', '.'); ?></td>
                <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                <td><?php echo htmlspecialchars($order['shipping_method']); ?></td>
                <td><?php echo htmlspecialchars($order['status']); ?></td>
                <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                <td>
                    <form method="POST" action="update_order_status.php" style="display: inline;">
                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                        <select name="status" required>
                            <option value="Chờ xử lý" <?php echo $order['status'] === 'Chờ xử lý' ? 'selected' : ''; ?>>Chờ xử lý</option>
                            <option value="Đang xử lý" <?php echo $order['status'] === 'Đang xử lý' ? 'selected' : ''; ?>>Đang xử lý</option>
                            <option value="Đã giao hàng" <?php echo $order['status'] === 'Đã giao hàng' ? 'selected' : ''; ?>>Đã giao hàng</option>
                            <option value="Đã giao" <?php echo $order['status'] === 'Đã giao' ? 'selected' : ''; ?>>Đã giao</option>
                            <option value="Đã hủy" <?php echo $order['status'] === 'Đã hủy' ? 'selected' : ''; ?>>Đã hủy</option>
                        </select>
                        <button type="submit">Cập nhật</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
