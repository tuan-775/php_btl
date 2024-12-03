<?php
require 'db.php';
session_start();

// Kiểm tra category được truyền qua URL
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Lấy sản phẩm mới nhất theo category (nếu có)
if ($category) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category = ? ORDER BY created_at DESC LIMIT 20");
    $stmt->execute([$category]);
} else {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 20");
}
$new_arrivals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Arrival - <?php echo htmlspecialchars($category ?: 'Tất cả'); ?></title>
    <link rel="stylesheet" href="css/style.css"> <!-- Thêm link CSS -->
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="breadcrumb">
            <a href="index.php">Trang chủ</a> / 
            <?php if ($category): ?>
                <a href="new_arrival.php">New Arrival</a> / <span><?php echo htmlspecialchars($category); ?></span>
            <?php else: ?>
                <span>New Arrival</span>
            <?php endif; ?>
        </div>

        <h1>New Arrival <?php echo htmlspecialchars($category ?: 'Tất cả'); ?></h1>
        <div class="product-container">
            <?php if (count($new_arrivals) > 0): ?>
                <?php foreach ($new_arrivals as $product): ?>
                    <div class="product-card">
                        <a href="product_detail.php?id=<?php echo $product['id']; ?>">
                            <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p><?php echo number_format($product['price'], 0, ',', '.'); ?> VND</p>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Không có sản phẩm nào trong danh mục này.</p>
            <?php endif; ?>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
