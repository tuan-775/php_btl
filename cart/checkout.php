<?php
session_start();
require '../db.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Lấy danh sách sản phẩm trong giỏ hàng
$stmt = $pdo->prepare("SELECT cart.id AS cart_id, products.id AS product_id, products.name AS product_name, 
           products.price, cart.quantity, products.stock
    FROM cart
    JOIN products ON cart.product_id = products.id 
    WHERE cart.user_id = ?");
$stmt->execute([$user_id]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($cartItems)) {
    die("Giỏ hàng của bạn đang trống.");
}

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
    $payment_method = trim($_POST['payment_method']);
    $shipping_method = trim($_POST['shipping_method']);
    $bank = isset($_POST['bank']) ? trim($_POST['bank']) : null;

    if (empty($name) || empty($address) || empty($phone) || empty($payment_method) || empty($shipping_method)) {
        $error = "Vui lòng điền đầy đủ thông tin.";
    } elseif ($payment_method === 'bank_transfer' && empty($bank)) {
        $error = "Vui lòng chọn ngân hàng nếu thanh toán qua chuyển khoản.";
    } elseif (empty($cartItems)) {
        $error = "Giỏ hàng của bạn đang trống.";
    } else {
        try {
            $pdo->beginTransaction();

            // Kiểm tra số lượng tồn kho
            foreach ($cartItems as $item) {
                if ($item['quantity'] > $item['stock']) {
                    $error = "Sản phẩm '" . htmlspecialchars($item['product_name']) . "' không đủ số lượng trong kho.";
                    throw new Exception($error);
                }
            }

            // Tính phí vận chuyển
            $shipping_cost = 0;
            if ($shipping_method === 'standard') {
                $shipping_cost = 30000; // 30,000 VND
            } elseif ($shipping_method === 'express') {
                $shipping_cost = 50000; // 50,000 VND
            }

            // Tính tổng tiền của đơn hàng
            $total_price = $total + $shipping_cost;

            // Lưu từng sản phẩm vào bảng orders và cập nhật kho
            foreach ($cartItems as $item) {
                $stmt = $pdo->prepare("INSERT INTO orders (user_id, user_name, phone, address, product_id, product_name, price, quantity, payment_method, shipping_method, bank, total_price, shipping_cost) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $user_id, $name, $phone, $address, $item['product_id'], $item['product_name'], $item['price'], $item['quantity'],
                    $payment_method, $shipping_method, $bank, $total_price, $shipping_cost
                ]);

                // Cập nhật số lượng tồn kho và số lượng đã bán
                $update_stock_stmt = $pdo->prepare("UPDATE products SET stock = stock - ?, sold_quantity = sold_quantity + ? WHERE id = ?");
                $update_stock_stmt->execute([$item['quantity'], $item['quantity'], $item['product_id']]);
            }

            // Xóa giỏ hàng sau khi đặt hàng
            $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
            $stmt->execute([$user_id]);

            $pdo->commit();

            // Lưu tổng tiền và chuyển hướng đến trang cảm ơn
            $_SESSION['thank_you_total'] = $total_price; // Lưu tổng tiền vào session
            $_SESSION['shipping_cost'] = $shipping_cost; // Lưu phí vận chuyển vào session
            // Chuyển hướng đến trang cảm ơn
            header("Location: thank_you.php");
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            if (empty($error)) {
                $error = "Đã xảy ra lỗi khi đặt hàng. Vui lòng thử lại!";
            }
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
                    <h2 id="total-price-display">Tổng tiền: <?php echo number_format($total, 0, ',', '.'); ?> VND</h2>
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
                    <div class="form-group">
                        <label for="payment_method">Phương thức thanh toán:</label>
                        <select id="payment_method" name="payment_method" required onchange="toggleBankSelection(this.value)">
                            <option value="">-- Chọn phương thức --</option>
                            <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                            <option value="bank_transfer">Chuyển khoản ngân hàng</option>
                        </select>
                    </div>
                    <div class="form-group" id="bank-selection" style="display: none;">
                        <label for="bank">Chọn ngân hàng:</label>
                        <select id="bank" name="bank">
                            <option value="">-- Chọn ngân hàng --</option>
                            <option value="MB">Ngân hàng MB</option>
                            <option value="VCB">Ngân hàng Vietcombank</option>
                            <option value="Agribank">Ngân hàng Agribank</option>
                        </select>
                        <div id="qr-codes" style="margin-top: 10px;">
                            <img id="mb-qr" src="../images/image.png" alt="QR MB" style="display: none; width: 200px;">
                            <img id="vcb-qr" src="../images/vcb-qr.png" alt="QR VCB" style="display: none; width: 200px;">
                            <img id="agr-qr" src="../images/agr-qr.png" alt="QR Agribank" style="display: none; width: 200px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="shipping_method">Phương thức vận chuyển:</label>
                        <select id="shipping_method" name="shipping_method" required onchange="updateTotalPrice()">
                            <option value="">-- Chọn phương thức --</option>
                            <option value="standard" data-cost="30000">Giao hàng tiêu chuẩn - 30,000 VND</option>
                            <option value="express" data-cost="50000">Giao hàng nhanh - 50,000 VND</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-checkout">Hoàn thành</button>
                </form>
            </div>
        <?php endif; ?>
    </main>
    <?php include '../footer.php'; ?>

    <script>
        function toggleBankSelection(paymentMethod) {
            const bankSelection = document.getElementById('bank-selection');
            const qrImages = document.querySelectorAll('#qr-codes img');

            if (paymentMethod === 'bank_transfer') {
                bankSelection.style.display = 'block';
            } else {
                bankSelection.style.display = 'none';
                qrImages.forEach(img => img.style.display = 'none');
            }
        }

        function updateTotalPrice() {
            const shippingSelect = document.getElementById('shipping_method');
            const selectedOption = shippingSelect.options[shippingSelect.selectedIndex];
            const shippingCost = parseInt(selectedOption.getAttribute('data-cost')) || 0;
            const baseTotal = <?php echo $total; ?>;
            const totalPriceDisplay = document.getElementById('total-price-display');

            const finalTotal = baseTotal + shippingCost;
            totalPriceDisplay.innerText = `Tổng tiền: ${finalTotal.toLocaleString('vi-VN')} VND`;
        }

        document.getElementById('bank').addEventListener('change', function () {
            const qrImages = {
                MB: document.getElementById('mb-qr'),
                VCB: document.getElementById('vcb-qr'),
                Agribank: document.getElementById('agr-qr')
            };

            Object.keys(qrImages).forEach(bank => {
                qrImages[bank].style.display = this.value === bank ? 'block' : 'none';
            });
        });
    </script>
</body>

</html>
