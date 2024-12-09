<?php
session_start();
require '../db.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Lấy danh sách sản phẩm trong giỏ hàng
$stmt = $pdo->prepare("
    SELECT cart.id AS cart_id, products.id AS product_id, products.name AS product_name, 
           products.price, cart.quantity
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

// Xử lý form đặt hàng
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);

    if (empty($name) || empty($address) || empty($phone)) {
        $error = "Vui lòng điền đầy đủ thông tin.";
    } elseif (empty($cartItems)) {
        $error = "Giỏ hàng của bạn đang trống.";
    } else {
        try {
            $pdo->beginTransaction();

            // Lưu từng sản phẩm vào bảng orders
            foreach ($cartItems as $item) {
                $stmt = $pdo->prepare("
                    INSERT INTO orders (user_name, phone, address, product_id, product_name, price, quantity)
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([$name, $phone, $address, $item['product_id'], $item['product_name'], $item['price'], $item['quantity']]);
            }

            // Xóa giỏ hàng sau khi đặt hàng
            $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
            $stmt->execute([$user_id]);

            $pdo->commit();

            // Chuyển hướng đến trang cảm ơn
            header("Location: thank_you.php");
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "Đã xảy ra lỗi khi đặt hàng. Vui lòng thử lại!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>

<body>
    <?php include '../header.php'; ?>
    <main class="checkout-main">
        <h1>Thanh toán</h1>

        <!-- Hiển thị thông báo lỗi nếu có -->
        <?php if (!empty($error)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <!-- Kiểm tra giỏ hàng -->
        <?php if (empty($cartItems)): ?>
            <p class="empty-cart">Giỏ hàng của bạn đang trống.</p>
            <a href="../index.php" class="btn-back-to-shop">Quay lại mua sắm</a>
        <?php else: ?>
            <div class="checkout-container">
                <div class="order-summary">
                    <h2>Tổng tiền: <?php echo number_format($total, 0, ',', '.'); ?> VND</h2>
                </div>
                <form method="POST" class="checkout-form">
                    <div class="form-group">
                        <label for="name">Họ và tên:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ:</label>
                        <input type="text" id="address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại:</label>
                        <input type="text" id="phone" name="phone" required>
                    </div>
                    <button type="submit" class="btn-checkout">Hoàn thành</button>
                </form>
            </div>
        <?php endif; ?>
    </main>
    <?php include '../footer.php'; ?>
</body>

</html>