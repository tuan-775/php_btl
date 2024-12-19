<?php
session_start();
require '../../db.php';

// Kiểm tra người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Lấy lịch sử mua hàng chỉ với trạng thái "Đã nhận"
$stmt = $pdo->prepare(
    "SELECT id AS order_id, created_at 
     FROM orders 
     WHERE user_id = ? AND status = 'Đã nhận'
     ORDER BY created_at DESC"
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
    <link rel="stylesheet" href="../../css/purchase_history.css">
    <link rel="stylesheet" href="../../css/footer.css">
    <link rel="stylesheet" href="../../css/header.css">
</head>

<body>
    <?php include '../../header.php'; ?>

    <main>
        <div class="order-history-container">
            <h1>Lịch sử mua hàng</h1>

            <?php if (empty($orders)): ?>
                <p>Bạn chưa có đơn hàng nào với trạng thái "Đã nhận".</p>
            <?php else: ?>
                <table class="order-history-table">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Ngày mua</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                                <td>
                                    <a href="order_details.php?order_id=<?php echo $order['order_id']; ?>" class="view-details-btn">Xem chi tiết</a>
                                </td>
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

    <?php include '../../footer.php'; ?>
</body>

</html>
