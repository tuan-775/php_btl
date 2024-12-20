<?php
require '../../db.php';
session_start();

// Kiểm tra người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

if (!isset($_GET['order_id'])) {
    die("Không tìm thấy đơn hàng.");
}

$order_id = $_GET['order_id'];
$user_id = $_SESSION['user_id'];

// Truy vấn lấy thông tin đơn hàng
$stmt_order = $pdo->prepare("
    SELECT * FROM orders WHERE id = ? AND user_id = ?
");
$stmt_order->execute([$order_id, $user_id]);
$order = $stmt_order->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    die("Đơn hàng không tồn tại hoặc bạn không có quyền xem đơn hàng này.");
}

// Truy vấn sản phẩm trong đơn hàng
$stmt_items = $pdo->prepare("
    SELECT oi.product_id, oi.product_name, oi.quantity, oi.price AS product_price, p.image
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$stmt_items->execute([$order_id]);
$order_items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);

// Xử lý đánh giá sản phẩm
if (isset($_POST['submit_review'])) {
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    if (!empty($rating) && !empty($review)) {
        $stmt_review = $pdo->prepare("
            INSERT INTO product_reviews (order_id, product_id, user_id, rating, review) 
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt_review->execute([$order_id, $product_id, $user_id, $rating, $review]);
        $success_message = "Cảm ơn bạn đã đánh giá sản phẩm!";
    } else {
        $error_message = "Vui lòng điền đầy đủ thông tin đánh giá!";
    }
}

// Kiểm tra xem người dùng đã đánh giá sản phẩm chưa
function hasReviewed($order_id, $product_id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM product_reviews WHERE order_id = ? AND product_id = ?");
    $stmt->execute([$order_id, $product_id]);
    return $stmt->fetchColumn() > 0;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết Đơn hàng</title>
    <link rel="stylesheet" href="../../css/user_orders1.css">
    <link rel="stylesheet" href="../../css/footer.css">
    <link rel="stylesheet" href="../../css/header.css">
</head>

<body>
    <?php //include '../../header.php'; 
    ?>
    <main>
        <h1>Chi tiết Đơn Hàng #<?php echo htmlspecialchars($order['id']); ?></h1>
        <a href="user_orders.php">Quay về Đơn hàng</a>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Hình ảnh</th>
                <th>Hành động</th>
            </tr>
            <?php foreach ($order_items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>₫<?php echo number_format($item['product_price'], 0, ',', '.'); ?></td>
                    <td>
                        <img src="/php_btl/uploads/<?php echo htmlspecialchars($item['image']); ?>" width="50" height="50" alt="Ảnh sản phẩm">
                    </td>
                    <td>
                        <?php if ($order['status'] === 'Đã nhận' && !hasReviewed($order_id, $item['product_id'])): ?>
                            <button onclick="openReviewPopup(<?php echo $order_id; ?>, <?php echo $item['product_id']; ?>)">Đánh giá</button>
                        <?php else: ?>
                            <span><?php echo ($order['status'] !== 'Đã nhận') ? "Chưa xác nhận" : "Đã đánh giá"; ?></span>
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

        <!-- Popup đánh giá sản phẩm -->
        <div id="reviewPopup" class="popup">
            <div class="popup-content">
                <span class="close-btn" onclick="closeReviewPopup()">&times;</span>
                <h2>Đánh Giá Sản Phẩm</h2>
                <form method="POST" action="">
                    <input type="hidden" name="product_id" id="product_id">
                    <label for="rating">Đánh giá (1-5 sao):</label>
                    <input type="number" name="rating" id="rating" min="1" max="5" required><br>
                    <label for="review">Nhận xét:</label>
                    <textarea name="review" id="review" rows="5" required></textarea><br>
                    <button type="submit" name="submit_review">Gửi Đánh Giá</button>
                </form>
            </div>
        </div>
    </main>

    <script>
        function openReviewPopup(orderId, productId) {
            document.getElementById('product_id').value = productId;
            document.getElementById('reviewPopup').style.display = 'flex';
        }

        function closeReviewPopup() {
            document.getElementById('reviewPopup').style.display = 'none';
        }
    </script>
    <?php //include '../../footer.php'; 
    ?>
</body>

</html>