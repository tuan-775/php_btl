<?php
require 'db.php';
session_start();

// Lấy thông tin filter từ URL
$category = isset($_GET['category']) ? $_GET['category'] : '';
$sale_range = isset($_GET['sale_range']) ? $_GET['sale_range'] : '';

// Tạo câu query cơ bản
$query = "SELECT * FROM products WHERE sale_percentage > 0";
$params = [];

// Thêm điều kiện lọc theo danh mục (nếu có)
if ($category) {
    $query .= " AND category = ?";
    $params[] = $category;
}

// Thêm điều kiện lọc theo khoảng giảm giá
if ($sale_range) {
    if ($sale_range == '10-25') {
        $query .= " AND sale_percentage BETWEEN 10 AND 25";
    } elseif ($sale_range == '25-50') {
        $query .= " AND sale_percentage BETWEEN 25 AND 50";
    }
}

// Thực thi câu query
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$sale_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SALE</title>
    <link rel="stylesheet" href="./css/sale.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <main>
        <nav class="breadcrumb">
            <a href="index.php">Trang chủ</a> /
            <span>
                <?php
                if (isset($_GET['sale_percentage']) && $_GET['sale_percentage'] === 'Sale 10%-25%') {
                    echo "Sale 10%-25%";
                } elseif (isset($_GET['sale_percentage']) && $_GET['sale_percentage'] == '25-50') {
                    echo "Sale 25%-50%";
                } elseif (isset($_GET['sale']) && $_GET['sale'] == 'girls') {
                    echo "Sale Bé Gái";
                } elseif (isset($_GET['sale']) && $_GET['sale'] == 'boys') {
                    echo "Sale Bé Trai";
                } else {
                    echo "Sale";
                }
                ?>
            </span>
        </nav>

        <h1>SALE</h1>
        <div class="product">
            <!-- Hiển thị sản phẩm -->
            <div class="product-container">
                <?php if (count($sale_products) > 0): ?>
                    <?php foreach ($sale_products as $product): ?>
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
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Không có sản phẩm nào trong danh mục này.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>