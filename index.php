<?php
session_start();
require 'db.php';

// Lấy danh sách sản phẩm, bao gồm cột sold_quantity
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="./css/index.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <!-- Danh sách sản phẩm -->
        <div class="product">
            <div class="product-container">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <a href="product_detail.php?id=<?php echo $product['id']; ?>">
                            <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <?php if ($product['sale_percentage'] > 0): ?>
                                <span class="sale-percentage">Giảm <?php echo htmlspecialchars($product['sale_percentage']); ?>%</span>
                                <p class="price-sale">
                                    ₫<?php
                                        $sale_price = $product['price'] * (1 - $product['sale_percentage'] / 100);
                                        echo number_format($sale_price, 0, ',', '.'); ?>
                                </p>
                            <?php else: ?>
                                <p class="price">₫<?php echo number_format($product['price'], 0, ',', '.'); ?></p>
                            <?php endif; ?>

                            <!-- Hiển thị số lượng đã bán -->
                            <p class="sold-quantity">Đã bán: <?php echo number_format($product['sold_quantity'], 0, ',', '.'); ?></p>

                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
