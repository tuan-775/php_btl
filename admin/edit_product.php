<?php
session_start();
require '../db.php';

if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập.";
    exit;
}

// Lấy thông tin sản phẩm từ ID
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Sản phẩm không tồn tại.");
}

// Xử lý cập nhật sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_code = $_POST['product_code'];
    $category = isset($_POST['category']) ? implode(',', $_POST['category']) : ''; // Multiple categories
    $category_name = $_POST['category_name']; // Tên loại sản phẩm
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $sale_percentage = $_POST['sale_percentage'];
    $stock = $_POST['stock'];
    $cost_price = $_POST['cost_price'];

    // Nếu người dùng chọn ảnh mới
    $image = $_FILES['image']['name'] ? $_FILES['image']['name'] : $product['image'];
    $target = "../uploads/" . basename($image);

    // Di chuyển ảnh nếu được upload
    if ($_FILES['image']['name']) {
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $error = "Tải ảnh lên thất bại.";
        }
    }

    // Cập nhật sản phẩm
    $stmt = $pdo->prepare("
        UPDATE products 
        SET product_code = ?, category = ?, category_name = ?, name = ?, description = ?, price = ?, sale_percentage = ?, stock = ?, cost_price = ?, image = ?
        WHERE id = ?
    ");
    $stmt->execute([$product_code, $category, $category_name, $name, $description, $price, $sale_percentage, $stock, $cost_price, $image, $product_id]);

    header("Location: dashboard.php?message=Product updated successfully");
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
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="product_code">Mã sản phẩm:</label>
        <input type="text" id="product_code" name="product_code" value="<?php echo htmlspecialchars($product['product_code']); ?>" required>

        <label for="category">Chọn loại sản phẩm:</label>
        <div class="checkbox-group">
            <?php
            $categories = ['Bé gái', 'Bé trai', 'BST Thu Đông', 'BST Đồ Bộ Mặc Nhà', 'BST Đồ Đi Chơi Noel', 'BST Disney - Friends'];
            $selected_categories = explode(',', $product['category']);
            foreach ($categories as $cat): ?>
                <label>
                    <input type="checkbox" name="category[]" value="<?php echo $cat; ?>"
                        <?php echo in_array($cat, $selected_categories) ? 'checked' : ''; ?>>
                    <?php echo $cat; ?>
                </label>
            <?php endforeach; ?>
        </div>

        <label for="category_name">Tên loại sản phẩm:</label>
        <input type="text" id="category_name" name="category_name" value="<?php echo htmlspecialchars($product['category_name']); ?>" required>

        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

        <label for="description">Mô tả:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>

        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>

        <label for="sale_percentage">Giảm giá (%):</label>
        <input type="number" id="sale_percentage" name="sale_percentage" value="<?php echo htmlspecialchars($product['sale_percentage']); ?>" required>

        <label for="stock">Số lượng tồn kho:</label>
        <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required>

        <label for="cost_price">Giá nhập:</label>
        <input type="number" id="cost_price" name="cost_price" value="<?php echo htmlspecialchars($product['cost_price']); ?>" required>

        <label for="image">Hình ảnh:</label>
        <input type="file" id="image" name="image">
        <img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="Hình ảnh sản phẩm" style="max-width: 100px; margin-top: 10px;">

        <button type="submit">Lưu thay đổi</button>
    </form>
    <a href="dashboard.php" class="back-btn">Quay lại</a>
</body>

</html>