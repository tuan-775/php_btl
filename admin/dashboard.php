<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập.";
    exit;
}

require '../db.php';

// Lấy danh sách sản phẩm
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <header>
        <h1>Danh sách sản phẩm</h1>
    </header>
    <main>
        <!-- Nút quay lại trang index -->
        <a href="../index.php" class="back-btn">Quay lại Trang chủ</a>
        <!-- Liên kết đến trang thêm sản phẩm -->
        <a href="add_product.php" class="add-btn">Thêm sản phẩm mới</a>

        <!-- Danh sách sản phẩm -->
        <h2>Danh sách sản phẩm</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mã sản phẩm</th>
                    <th>Loại sản phẩm</th>
                    <th>Tên loại sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Mô tả</th>
                    <th>Giá</th>
                    <th>Ngày thêm</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['id']); ?></td>
                        <td><?php echo htmlspecialchars($product['product_code']); ?></td>
                        <td><?php echo htmlspecialchars($product['category']); ?></td>
                        <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td>
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 50px; height: 50px;">
                        </td>
                        <td><?php echo htmlspecialchars($product['description']); ?></td>
                        <td><?php echo htmlspecialchars($product['price']); ?> VND</td>
                        <td><?php echo htmlspecialchars($product['created_at']); ?></td>
                        <td class="action-buttons">
                            <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="edit-btn">Sửa</a>
                            <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="delete-btn" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
