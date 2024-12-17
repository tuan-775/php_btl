<?php
require 'db.php';
session_start();

// Lấy danh mục từ URL
$category_name = isset($_GET['category_name']) ? trim($_GET['category_name']) : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';

// Truy vấn sản phẩm
if (!empty($category_name) && !empty($category)) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category LIKE CONCAT('%', ?, '%') AND category_name = ?");
    $stmt->execute([$category, $category_name]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif (!empty($category)) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category LIKE CONCAT('%', ?, '%')");
    $stmt->execute([$category]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    die("Vui lòng chọn danh mục hợp lệ.");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($category_name); ?></title>
    <link rel="stylesheet" href="./css/category.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="breadcrumb">
            <a href="index.php">Trang chủ</a> /
            <a href="category.php?category=<?php echo urlencode($category); ?>">
                <?php echo htmlspecialchars($category); ?>
            </a>
            <?php if (!empty($category_name)): ?>
                / <span><?php echo htmlspecialchars($category_name); ?></span>
            <?php endif; ?>
        </div>

        <?php if (empty($products)): ?>
            <p>Không có sản phẩm nào trong danh mục này.</p>
        <?php else: ?>
            <div class="product">
                <div class="product-container">
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <a href="product_detail.php?id=<?php echo $product['id']; ?>">
                                <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                                <p class="price">
                                    ₫<?php echo number_format($product['price'], 0, ',', '.'); ?>
                                </p>
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