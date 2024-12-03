<?php
require '../db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login/login.php");
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
    $cart_item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cart_item) {
        // Cập nhật số lượng nếu sản phẩm đã có
        $new_quantity = $cart_item['quantity'] + $quantity;
        $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$new_quantity, $user_id, $product_id]);
    } else {
        // Thêm sản phẩm mới vào giỏ hàng
        $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $product_id, $quantity]);
    }

    // Chuyển hướng về giỏ hàng
    header("Location: cart.php");
    exit;
}
?>
