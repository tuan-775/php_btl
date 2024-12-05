<?php
require '../db.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Lấy dữ liệu giỏ hàng từ bảng cart
$stmt = $pdo->prepare("
    SELECT cart.quantity, cart.product_id, products.name, products.price, products.sale_percentage, products.image 
    FROM cart 
    JOIN products ON cart.product_id = products.id 
    WHERE cart.user_id = ?
");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <div class="cart-container">
            <h1>Giỏ hàng của bạn</h1>
            <?php if (empty($cart_items)): ?>
                <div class="empty-cart">
                    <p>Giỏ hàng của bạn đang trống!</p>
                    <a href="../index.php" class="btn-return">Quay lại Trang chủ</a>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá gốc</th>
                            <th>Giá giảm</th>
                            <th>Thành tiền</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($cart_items as $item):
                            $sale_price = $item['sale_percentage'] > 0
                                ? $item['price'] * (1 - $item['sale_percentage'] / 100)
                                : $item['price'];
                            $subtotal = $item['quantity'] * $sale_price;
                            $total += $subtotal;
                        ?>
                            <tr>
                                <td><img src="../uploads/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>"></td>
                                <td align="center"><?php echo htmlspecialchars($item['name']); ?></td>
                                <td align="center"><?php echo $item['quantity']; ?></td>
                                <td align="center"><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
                                <td align="center">
                                    <?php echo $item['sale_percentage'] > 0
                                        ? number_format($sale_price, 0, ',', '.') . ' VND'
                                        : '---'; ?>
                                </td>
                                <td align="center"><?php echo number_format($subtotal, 0, ',', '.'); ?> VND</td>
                                <td align="center">
                                    <a href="remove_from_cart.php?id=<?php echo $item['product_id']; ?>" class="btn-remove">Xóa</a>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="cart-total">
                    <p><strong>Tổng cộng:</strong> <?php echo number_format($total, 0, ',', '.'); ?> VND</p>
                    <a href="checkout.php" class="btn-checkout">Tiến hành thanh toán</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <?php include '../footer.php'; ?>
</body>

</html>