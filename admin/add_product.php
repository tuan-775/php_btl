<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập.";
    exit;
}

require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_code = $_POST['product_code'];
    $category = isset($_POST['category_name']) ? implode(', ', $_POST['category_name']) : ''; 
    $category_type = $_POST['category_type'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $sale_percentage = $_POST['sale_percentage'];
    $stock = $_POST['stock'];
    $cost_price = $_POST['cost_price'];

    // Upload ảnh chính
    $main_image = $_FILES['image']['name'];
    $target = "../uploads/" . basename($main_image);

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $error = "Failed to upload main image.";
    }

    // Thêm sản phẩm vào DB
    $stmt = $pdo->prepare("
        INSERT INTO products (product_code, category, category_name, name, description, price, sale_percentage, stock, cost_price, image) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$product_code, $category, $category_type, $name, $description, $price, $sale_percentage, $stock, $cost_price, $main_image]);

    $product_id = $pdo->lastInsertId(); // Lấy ID sản phẩm vừa thêm

    // Xử lý upload nhiều ảnh
    if (!empty($_FILES['additional_images']['name'][0])) {
        $additional_images = $_FILES['additional_images'];
        for ($i = 0; $i < count($additional_images['name']); $i++) {
            $filename = $additional_images['name'][$i];
            $filetmp = $additional_images['tmp_name'][$i];
            $target_additional = "../uploads/" . basename($filename);

            if (move_uploaded_file($filetmp, $target_additional)) {
                // Lưu vào bảng product_images
                $img_stmt = $pdo->prepare("INSERT INTO product_images (product_id, image_path) VALUES (?, ?)");
                $img_stmt->execute([$product_id, $filename]);
            } else {
                // Có thể xử lý lỗi từng ảnh hoặc bỏ qua
            }
        }
    }

    header("Location: dashboard.php?message=Product added successfully");
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
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="product_code">Mã sản phẩm:</label>
        <input type="text" id="product_code" name="product_code" required>

        <label for="category_name">Chọn loại sản phẩm:</label>
        <div class="checkbox-group">
            <label><input type="checkbox" name="category_name[]" value="Bé gái"> Bé gái</label>
            <label><input type="checkbox" name="category_name[]" value="Bé trai"> Bé trai</label>
            <label><input type="checkbox" name="category_name[]" value="BST Thu Đông"> BST Thu Đông</label>
            <label><input type="checkbox" name="category_name[]" value="BST Đồ Bộ Mặc Nhà"> BST Đồ Bộ Mặc Nhà</label>
            <label><input type="checkbox" name="category_name[]" value="BST Đồ Đi Chơi Noel"> BST Đồ Đi Chơi Noel</label>
            <label><input type="checkbox" name="category_name[]" value="BST Disney - Friends"> BST Disney - Friends</label>
        </div>

        <label for="category_type">Tên loại sản phẩm:</label>
        <input type="text" id="category_type" name="category_type" placeholder="Nhập tên loại sản phẩm..." required>

        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" required>

        <label for="description">Mô tả:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" required>

        <label for="sale_percentage">Giảm giá (%):</label>
        <input type="number" id="sale_percentage" name="sale_percentage" value="0">

        <label for="stock">Số lượng tồn kho:</label>
        <input type="number" id="stock" name="stock" required>

        <label for="cost_price">Giá nhập:</label>
        <input type="number" id="cost_price" name="cost_price" required>

        <label for="image">Hình ảnh chính:</label>
        <input type="file" id="image" name="image" required>

        <label for="additional_images">Hình ảnh phụ (chọn nhiều):</label>
        <input type="file" id="additional_images" name="additional_images[]" multiple>

        <button type="submit">Thêm sản phẩm</button>
    </form>
</body>

</html>
