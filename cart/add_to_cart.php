<?php
session_start();
require 'db.php';

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    // Redirect về trang đăng nhập và truyền thông báo
    header("Location: login/login.php?message=login_required");
    exit();
}

// Nếu người dùng đã đăng nhập, tiếp tục xử lý thêm vào giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Lấy thông tin sản phẩm từ database
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        // Kiểm tra nếu giỏ hàng đã tồn tại trong session
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Nếu sản phẩm đã tồn tại trong giỏ hàng, tăng số lượng
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            // Nếu sản phẩm chưa tồn tại, thêm mới vào giỏ hàng
            $_SESSION['cart'][$product_id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => $quantity,
            ];
        }

        // Chuyển hướng về trang giỏ hàng hoặc hiển thị thông báo
        header("Location: cart.php");
        exit();
    }
}
?>
