<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập.";
    exit;
}

require '../db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "Sản phẩm không tồn tại.";
    exit;
}

// Lấy thông tin sản phẩm hiện tại
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Sản phẩm không tồn tại.";
    exit;
}

// Xử lý cập nhật sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_code = $_POST['product_code'];
    $category = $_POST['category'];
    $category_name = $_POST['category_name'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $sale_percentage = $_POST['sale_percentage'];

    // Xử lý upload ảnh mới nếu có
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
        $image_url = $product['image']; // Giữ nguyên ảnh cũ nếu không thay đổi
    }

    // Cập nhật sản phẩm
    $stmt = $pdo->prepare("UPDATE products SET product_code = ?, category = ?, category_name = ?, name = ?, image = ?, description = ?, price = ?, sale_percentage = ? WHERE id = ?");
    $stmt->execute([$product_code, $category, $category_name, $name, $image_url, $description, $price, $sale_percentage, $id]);

    echo "Cập nhật sản phẩm thành công!";
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sản phẩm</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <h1>Sửa sản phẩm</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="product_code">Mã sản phẩm:</label><br>
        <input type="text" id="product_code" name="product_code" value="<?php echo htmlspecialchars($product['product_code']); ?>" required><br><br>

        <label for="category">Loại sản phẩm:</label><br>
        <select id="category" name="category" required>
            <option value="Bé gái" <?php echo $product['category'] === 'Bé gái' ? 'selected' : ''; ?>>Bé gái</option>
            <option value="Bé trai" <?php echo $product['category'] === 'Bé trai' ? 'selected' : ''; ?>>Bé trai</option>
        </select><br><br>

        <label for="category_name">Tên loại sản phẩm:</label><br>
        <input type="text" id="category_name" name="category_name" value="<?php echo htmlspecialchars($product['category_name']); ?>" required><br><br>

        <label for="name">Tên sản phẩm:</label><br>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required><br><br>

        <label for="description">Mô tả:</label><br>
        <textarea id="description" name="description" rows="5" required><?php echo htmlspecialchars($product['description']); ?></textarea><br><br>

        <label for="price">Giá:</label><br>
        <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required><br><br>

        <label for="sale_percentage">Giảm giá (%):</label><br>
        <input type="number" id="sale_percentage" name="sale_percentage" value="<?php echo htmlspecialchars($product['sale_percentage']); ?>" min="0" max="100"><br><br>

        <label for="image">Ảnh sản phẩm:</label><br>
        <input type="file" id="image" name="image"><br>
        <p>Ảnh hiện tại:</p>
        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 100px; height: 100px;"><br><br>

        <button type="submit">Cập nhật</button>
    </form>
    <a href="dashboard.php">Quay lại danh sách</a>
</body>
</html>
