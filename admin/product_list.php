<?php
session_start();
require '../db.php';

if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập.";
    exit;
}

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
    <link rel="stylesheet" href="../css/product_list.css">
</head>

<body>
    <header>
        <h1>Danh sách sản phẩm</h1>
    </header>
    <main>
        <a href="dashboard.php" class="back-btn">Quay lại quản trị</a>
        <a href="add_product.php" class="add-btn">Thêm sản phẩm mới</a>
        <div class="table-container">
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
                        <th>Giá bán</th>
                        <th>Giá nhập</th>
                        <th>Tồn kho</th>
                        <th>Ngày thêm</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <?php
                        // Lấy danh sách ảnh phụ cho sản phẩm này
                        $img_stmt = $pdo->prepare("SELECT * FROM product_images WHERE product_id = ?");
                        $img_stmt->execute([$product['id']]);
                        $additional_images = $img_stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['id']); ?></td>
                            <td><?php echo htmlspecialchars($product['product_code']); ?></td>
                            <td><?php echo htmlspecialchars($product['category']); ?></td>
                            <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td>
                                <!-- Ảnh chính -->
                                <img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 50px; height: 50px;">

                                <!-- Ảnh phụ -->
                                <?php foreach ($additional_images as $img): ?>
                                    <img src="../uploads/<?php echo htmlspecialchars($img['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 50px; height: 50px; margin-left:5px;">
                                <?php endforeach; ?>
                            </td>
                            <td><?php echo htmlspecialchars($product['description']); ?></td>
                            <td><?php echo number_format($product['price'], 0, ',', '.'); ?> VND</td>
                            <td><?php echo number_format($product['cost_price'], 0, ',', '.'); ?> VND</td>
                            <td><?php echo htmlspecialchars($product['stock']); ?></td>
                            <td><?php echo htmlspecialchars($product['created_at']); ?></td>
                            <td>
                                <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn-edit">Sửa</a>
                                <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>
