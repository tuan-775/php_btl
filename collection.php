<?php
require 'db.php';
session_start();

// Lấy tên bộ sưu tập từ URL
$collection = isset($_GET['collection']) ? trim($_GET['collection']) : '';

if (!empty($collection)) {
    // Truy vấn các sản phẩm thuộc bộ sưu tập
    $stmt = $pdo->prepare("
        SELECT * FROM products 
        WHERE FIND_IN_SET(?, category) > 0
    ");
    $stmt->execute([$collection]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Không có thông tin bộ sưu tập hợp lệ
    die("Vui lòng chọn bộ sưu tập hợp lệ.");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($collection); ?></title>
    <link rel="stylesheet" href="./css/sale.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="breadcrumb">
            <a href="index.php">Trang chủ</a> /
            <span><?php echo htmlspecialchars($collection); ?></span>
        </div>

        <?php if (empty($products)): ?>
            <p>Không có sản phẩm nào trong bộ sưu tập này.</p>
        <?php else: ?>
            <div class="product">
                <div class="product-container">
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <a href="product_detail.php?id=<?php echo $product['id']; ?>">
                                <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                                <?php if ($product['sale_percentage'] > 0): ?>
                                    <div class="price-sale">
                                        ₫<?php
                                            $sale_price = $product['price'] * (1 - $product['sale_percentage'] / 100);
                                            echo number_format($sale_price, 0, ',', '.'); ?> <span class="sale-percentage">-<?php echo htmlspecialchars($product['sale_percentage']); ?>%</span>
                                    </div>
                                <?php else: ?>
                                    <p class="price">₫<?php echo number_format($product['price'], 0, ',', '.'); ?></p>
                                <?php endif; ?>

                                <!-- Hiển thị số lượng đã bán -->
                                <div class="sold-quantity">Đã bán: <?php echo number_format($product['sold_quantity'], 0, ',', '.'); ?></div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>