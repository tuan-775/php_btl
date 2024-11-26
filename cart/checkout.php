<?php
session_start();
require '../db.php';

// Lấy danh sách sản phẩm trong giỏ hàng
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    if (empty($name) || empty($address) || empty($phone)) {
        $error = "Vui lòng điền đầy đủ thông tin.";
    } elseif (empty($cartItems)) {
        $error = "Giỏ hàng của bạn đang trống.";
    } else {
        // Lưu thông tin vào bảng orders
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

        // Chuyển hướng đến trang cảm ơn
        header("Location: thank_you.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link rel="stylesheet" href="../css/checkout.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../header.php'; ?>

<main>
    <h1>Thanh toán</h1>

    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (empty($cartItems)): ?>
        <p class="empty-cart">Giỏ hàng của bạn đang trống.</p>
        <a href="../index.php" class="back-to-shop">Quay lại mua sắm</a>
    <?php else: ?>
        <div class="checkout-container">
            <div class="order-summary">
                <h2>Tổng tiền: <?php echo number_format($total, 0, ',', '.'); ?> VND</h2>
            </div>
            <form method="POST" class="checkout-form">
                <label for="name">Họ và tên:</label>
                <input type="text" id="name" name="name" required>

                <label for="address">Địa chỉ:</label>
                <input type="text" id="address" name="address" required>

                <label for="phone">Số điện thoại:</label>
                <input type="text" id="phone" name="phone" required>

                <button type="submit" class="btn-checkout">Hoàn thành</button>
            </form>
        </div>
    <?php endif; ?>
</main>

<?php include '../footer.php'; ?>
</body>
</html>
