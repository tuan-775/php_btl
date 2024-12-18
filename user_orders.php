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
           orders.payment_method, orders.shipping_method, products.image, orders.created_at, products.id AS product_id
    FROM orders
    JOIN products ON orders.product_id = products.id
    WHERE orders.user_id = ?
    ORDER BY orders.created_at DESC
");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Kiểm tra khi người dùng gửi đánh giá
if (isset($_POST['submit_review'])) {
    $order_id = $_POST['order_id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];
    $product_id = $_POST['product_id'];

    // Kiểm tra nếu người dùng đã điền đủ thông tin đánh giá
    if (!empty($rating) && !empty($review)) {
        // Lưu đánh giá vào cơ sở dữ liệu
        $sql = "INSERT INTO product_reviews (order_id, product_id, user_id, rating, review) 
                VALUES (:order_id, :product_id, :user_id, :rating, :review)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':order_id' => $order_id,
            ':product_id' => $product_id,
            ':user_id' => $_SESSION['user_id'],
            ':rating' => $rating,
            ':review' => $review
        ]);

        $success_message = "Cảm ơn bạn đã đánh giá sản phẩm!";
    } else {
        $error_message = "Vui lòng điền đầy đủ thông tin!";
    }
}

// Kiểm tra xem người dùng đã đánh giá sản phẩm này chưa
function hasReviewed($user_id, $product_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM product_reviews WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
    return $stmt->fetchColumn() > 0; // Trả về true nếu đã đánh giá, false nếu chưa
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng của tôi</title>
    <link rel="stylesheet" href="./css/user_orders1.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <?php include './header.php' ?>
    <main>
        <div>
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
                            <img src="/php_btl/uploads/<?php echo htmlspecialchars($order['image']); ?>" width="50" height="50" alt="Ảnh sản phẩm">
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
                                <!-- Kiểm tra xem người dùng đã đánh giá chưa -->
                                <?php if (hasReviewed($_SESSION['user_id'], $order['product_id'])): ?>
                                    <!-- Nếu đã đánh giá rồi, không hiển thị nút "Đánh giá sản phẩm" -->
                                    <span></span>
                                <?php else: ?>
                                    <!-- Nút Đánh giá sản phẩm -->
                                    <button onclick="openReviewPopup(<?php echo $order['id']; ?>, <?php echo $order['product_id']; ?>)">Đánh giá sản phẩm</button>
                                <?php endif; ?>
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

            <?php if (isset($success_message)): ?>
                <p style="color: green;"><?php echo $success_message; ?></p>
            <?php endif; ?>
            
            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
        </div>
    </main>

    <!-- Popup Đánh giá sản phẩm -->
    <div id="reviewPopup" class="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="closeReviewPopup()">&times;</span>
            <h2>Đánh Giá Sản Phẩm</h2>
            <form method="POST" action="" style="display: inline;">
                <input type="hidden" name="order_id" id="order_id">
                <input type="hidden" name="product_id" id="product_id">
                
                <label for="rating">Đánh giá (1-5 sao):</label><br>
                <input type="number" name="rating" id="rating" min="1" max="5" required><br><br>

                <label for="review">Nhận xét:</label><br>
                <textarea name="review" id="review" rows="5" required></textarea><br><br>

                <button type="submit" name="submit_review">Gửi Đánh Giá</button>
            </form>
        </div>
    </div>

    <?php include './footer.php' ?>

    <script>
        // Mở Popup đánh giá
        function openReviewPopup(orderId, productId) {
            document.getElementById('order_id').value = orderId; // Thiết lập giá trị order_id trong form
            document.getElementById('product_id').value = productId; // Thiết lập giá trị product_id trong form
            document.getElementById('reviewPopup').style.display = 'flex'; // Hiển thị popup
        }

        // Đóng Popup đánh giá
        function closeReviewPopup() {
            document.getElementById('reviewPopup').style.display = 'none'; // Ẩn popup
        }
    </script>
</body>

</html>
