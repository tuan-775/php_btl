<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập.";
    exit;
}

require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_code = $_POST['product_code'];
    $category = $_POST['category'];
    $category_name = $_POST['category_name'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $sale_percentage = isset($_POST['sale_percentage']) ? $_POST['sale_percentage'] : 0; // Xử lý sale_percentage

    // Xử lý upload ảnh
    $upload_dir = "../uploads/";
    $image_name = basename($_FILES['image']['name']);
    $target_file = $upload_dir . $image_name;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $image_url = $target_file;
    } else {
        echo "Lỗi khi tải ảnh lên.";
        exit;
    }

    // Thêm sản phẩm vào cơ sở dữ liệu
    $stmt = $pdo->prepare("
        INSERT INTO products (product_code, category, category_name, name, image, description, price, sale_percentage) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$product_code, $category, $category_name, $name, $image_url, $description, $price, $sale_percentage]);

    // Chuyển hướng về dashboard
    header("Location: dashboard.php?message=success");
    exit;
}
?>
