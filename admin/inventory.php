<?php
session_start();
require '../db.php';

if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập.";
    exit;
}

// Lấy thông tin tồn kho
$stmt = $pdo->query("SELECT id, name, image, stock, created_at FROM products ORDER BY name");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê tồn kho</title>
    <!-- <link rel="stylesheet" href="../css/product_list.css"> -->
    <link rel="stylesheet" href="./css/inventory.css">
</head>

<body>

    <main>
        <header>
            <h1>Thống kê tồn kho</h1>
        </header>
        <a href="dashboard.php" class="back-btn">Quay lại quản trị</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Số lượng tồn kho</th>
                    <th>Ngày nhập</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['id']); ?></td>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td>
                            <img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 50px; height: 50px; border-radius: 5px;">
                        </td>
                        <td><?php echo htmlspecialchars($product['stock']); ?></td>
                        <td><?php echo htmlspecialchars($product['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>

</html>