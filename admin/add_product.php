<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập.";
    exit;
}

require '../db.php';

// Xử lý thêm sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_code = $_POST['product_code'];
    $category = $_POST['category'];
    $category_name = $_POST['category_name'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Xử lý upload ảnh
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = "../uploads/";
        $image_name = basename($_FILES['image']['name']);
        $target_file = $upload_dir . $image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_url = $target_file;
        } else {
            echo "Lỗi khi tải ảnh lên.";
            exit;
        }
    } else {
        $image_url = ""; // Nếu không có ảnh, để trống
    }

    // Lưu sản phẩm vào cơ sở dữ liệu
    $stmt = $pdo->prepare("INSERT INTO products (product_code, category, category_name, name, image, description, price) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$product_code, $category, $category_name, $name, $image_url, $description, $price]);
    echo "Thêm sản phẩm thành công!";
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <h1>Thêm sản phẩm</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="product_code">Mã sản phẩm:</label>
        <input type="text" id="product_code" name="product_code" required><br>

        <label for="category">Loại sản phẩm:</label>
        <select id="category" name="category" required>
            <option value="Bé trai">Bé trai</option>
            <option value="Bé gái">Bé gái</option>
        </select><br>

        <label for="category_name">Tên loại sản phẩm:</label>
        <input type="text" id="category_name" name="category_name" required><br>

        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="image">Hình ảnh:</label>
        <input type="file" id="image" name="image" required><br>

        <label for="description">Mô tả:</label>
        <textarea id="description" name="description" required></textarea><br>

        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" required><br>

        <button type="submit">Thêm sản phẩm</button>
    </form>
</body>
</html>
