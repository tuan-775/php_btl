<?php
require '../db.php';
session_start();

// Kiểm tra quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Bạn không có quyền truy cập.");
}

// Xử lý hiển thị chi tiết đơn hàng
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Lấy thông tin đơn hàng chính
    $stmt_order = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt_order->execute([$order_id]);
    $order = $stmt_order->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        die("Đơn hàng không tồn tại.");
    }

    // Lấy thông tin sản phẩm trong đơn hàng từ bảng `order_items`
    $stmt_order_items = $pdo->prepare("
        SELECT oi.product_id, oi.product_name, oi.price AS product_price, oi.quantity 
        FROM order_items oi
        WHERE oi.order_id = ?
    ");
    $stmt_order_items->execute([$order_id]);
    $order_items = $stmt_order_items->fetchAll(PDO::FETCH_ASSOC);
}

// Cập nhật trạng thái đơn hàng
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    // Cập nhật trạng thái đơn hàng
    $update_stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $update_stmt->execute([$status, $order_id]);

    // Chuyển hướng lại trang sau khi cập nhật
    header("Location: view_order_details.php?order_id=$order_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết Đơn Hàng</title>
    <link rel="stylesheet" href="./css/manage_orders.css">
</head>
<body>
    <h1>Chi tiết Đơn Hàng</h1>

    <?php if (isset($order) && isset($order_items)): ?>
        <h2>Chi tiết Đơn Hàng #<?php echo htmlspecialchars($order['id']); ?></h2>
        
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>ID Đơn Hàng</th>
                <td><?php echo htmlspecialchars($order['id']); ?></td>
            </tr>
            <tr>
                <th>Người đặt</th>
                <td><?php echo htmlspecialchars($order['user_name']); ?></td>
            </tr>
            <tr>
                <th>Số điện thoại</th>
                <td><?php echo htmlspecialchars($order['phone']); ?></td>
            </tr>
            <tr>
                <th>Địa chỉ</th>
                <td><?php echo htmlspecialchars($order['address']); ?></td>
            </tr>
            <tr>
                <th>Phương thức thanh toán</th>
                <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
            </tr>
            <tr>
                <th>Phương thức vận chuyển</th>
                <td><?php echo htmlspecialchars($order['shipping_method']); ?></td>
            </tr>
            <tr>
                <th>Phí vận chuyển</th>
                <td>₫<?php echo number_format($order['shipping_cost'], 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <th>Tổng tiền</th>
                <td>₫<?php echo number_format($order['total_price'], 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <th>Ngày tạo</th>
                <td><?php echo htmlspecialchars($order['created_at']); ?></td>
            </tr>
        </table>

        <h3>Danh sách sản phẩm</h3>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Tổng cộng</th>
            </tr>
            <?php foreach ($order_items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>₫<?php echo number_format($item['product_price'], 0, ',', '.'); ?></td>
                    <td>₫<?php echo number_format($item['product_price'] * $item['quantity'], 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h3>Cập nhật trạng thái đơn hàng</h3>
        <form method="POST" action="" style="display: inline;">
            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
            <select name="status" required>
                <option value="Chờ xử lý" <?php echo $order['status'] === 'Chờ xử lý' ? 'selected' : ''; ?>>Chờ xử lý</option>
                <option value="Đang xử lý" <?php echo $order['status'] === 'Đang xử lý' ? 'selected' : ''; ?>>Đang xử lý</option>
                <option value="Đã giao hàng" <?php echo $order['status'] === 'Đã giao hàng' ? 'selected' : ''; ?>>Đã giao hàng</option>
                <option value="Đã giao" <?php echo $order['status'] === 'Đã giao' ? 'selected' : ''; ?>>Đã giao</option>
                <option value="Đã hủy" <?php echo $order['status'] === 'Đã hủy' ? 'selected' : ''; ?>>Đã hủy</option>
            </select>
            <button type="submit" name="update_status">Cập nhật</button>
        </form>
    <?php else: ?>
        <p>Không tìm thấy thông tin đơn hàng.</p>
    <?php endif; ?>
</body>
</html>
