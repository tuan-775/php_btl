<?php
session_start();
require '../db.php';

// Kiểm tra nếu người dùng đã đăng nhập
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Truy vấn giỏ hàng từ cơ sở dữ liệu
$stmt = $pdo->prepare("
    SELECT cart.id AS cart_id, products.name, products.image, products.price, cart.quantity
    FROM cart
    JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = ?
");
$stmt->execute([$user_id]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Tính tổng tiền
$total = 0;
foreach ($cartItems as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/cart.css">
</head>
<body>
<?php include '../header.php'; ?>

<main>
    <h1>Giỏ hàng của bạn</h1>

    <?php if (empty($cartItems)): ?>
        <p class="empty-cart">Giỏ hàng của bạn đang trống.</p>
        <a href="index.php" class="back-to-shop">Quay lại mua sắm</a>
    <?php else: ?>
        <div class="cart-container">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td>
                                <img src="../uploads/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                            </td>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VND</td>
                            <td>
                                <a href="remove_from_cart.php?cart_id=<?php echo $item['cart_id']; ?>" class="remove-btn">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-summary">
                <h3>Tổng tiền: <?php echo number_format($total, 0, ',', '.'); ?> VND</h3>
                <a href="checkout.php" class="checkout-btn">Thanh toán</a>
            </div>
        </div>
    <?php endif; ?>
</main>
<?php include '../footer.php'; ?>
</body>
</html>
