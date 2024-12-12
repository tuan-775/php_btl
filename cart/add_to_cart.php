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
    $selected_size = isset($_POST['selected_size']) ? $_POST['selected_size'] : '';

    // Kiểm tra nếu sản phẩm với kích cỡ này đã có trong giỏ hàng
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ? AND size = ?");
    $stmt->execute([$user_id, $product_id, $selected_size]);
    $cart_item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cart_item) {
        // Cập nhật số lượng nếu sản phẩm (cùng kích cỡ) đã có trong giỏ hàng
        $new_quantity = $cart_item['quantity'] + $quantity;
        $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ? AND size = ?");
        $stmt->execute([$new_quantity, $user_id, $product_id, $selected_size]);
    } else {
        // Thêm sản phẩm mới vào giỏ hàng cùng với kích cỡ
        $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, size, quantity) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $product_id, $selected_size, $quantity]);
    }

    // Chuyển hướng về giỏ hàng
    header("Location: cart.php");
    exit;
}
