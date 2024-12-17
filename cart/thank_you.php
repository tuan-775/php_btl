<?php
session_start();

// Kiểm tra nếu có dữ liệu từ session
if (!isset($_SESSION['thank_you_total']) || !isset($_SESSION['shipping_cost'])) {
    header("Location: ../index.php");
    exit;
}

$total_price = $_SESSION['thank_you_total'];
$shipping_cost = $_SESSION['shipping_cost'];

// Xóa dữ liệu để tránh hiển thị lại khi refresh
unset($_SESSION['thank_you_total']);
unset($_SESSION['shipping_cost']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cảm ơn</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/thank_you.css">
</head>

<body>
    <?php include '../header.php'; ?>
        <main class="thank-you-main">
            <h1>Cảm ơn bạn đã đặt hàng!</h1>
            <p>Tổng tiền đã thanh toán của bạn là: <strong><?php echo number_format($total_price, 0, ',', '.'); ?> VND</strong></p>
            <p>Trong đó phí vận chuyển: <strong><?php echo number_format($shipping_cost, 0, ',', '.'); ?> VND</strong></p>
            <p>Chúng tôi sẽ xử lý đơn hàng của bạn sớm nhất có thể!</p>
            <a href="../index.php" class="btn-back-to-home">Quay lại trang chủ</a>
        </main>
    <?php include '../footer.php'; ?>
</body>

</html>
