<?php
require 'db.php';
session_start();

// Lấy thông tin sản phẩm từ ID
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Sản phẩm không tồn tại.");
}

// Lấy các sản phẩm liên quan dựa trên category và category_name
$related_products_stmt = $pdo->prepare("
    SELECT * FROM products 
    WHERE category = ? AND category_name = ? AND id != ?
    LIMIT 4
");
$related_products_stmt->execute([$product['category'], $product['category_name'], $product_id]);
$related_products = $related_products_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
    <link rel="stylesheet" href="./css/product_detail.css">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> <!-- Font Awesome -->
</head>

<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="product-detail">
            <div class="product-image">
                <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
            <div class="product-info">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <p><strong>Mã sản phẩm:</strong> <?php echo htmlspecialchars($product['product_code']); ?></p>
                <p><strong>Mô tả:</strong> <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                <p><strong>Giá:</strong> <?php echo number_format($product['price'], 0, ',', '.'); ?> VND</p>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Nút "Thêm vào giỏ hàng" cho người dùng đã đăng nhập -->
                    <form action="cart/add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="number" name="quantity" value="1" min="1">
                        <button type="submit" name="add_to_cart">Thêm vào giỏ hàng</button>
                    </form>
                <?php else: ?>
                    <!-- Thông báo yêu cầu đăng nhập -->
                    <div class="notification-message">
                        <i class="fas fa-exclamation-circle"></i>
                        Vui lòng <a href="login/login.php">đăng nhập</a> để thêm sản phẩm vào giỏ hàng!
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="related-products">
            <h2>Sản phẩm liên quan</h2>
            <div class="related-products-container">
                <?php foreach ($related_products as $related): ?>
                    <div class="product-card">
                        <a href="product_detail.php?id=<?php echo $related['id']; ?>">
                            <img src="uploads/<?php echo htmlspecialchars($related['image']); ?>" alt="<?php echo htmlspecialchars($related['name']); ?>">
                            <h3><?php echo htmlspecialchars($related['name']); ?></h3>
                            <?php if ($related['sale_percentage'] > 0): ?>
                                <span class="sale-percentage">Giảm <?php echo htmlspecialchars($related['sale_percentage']); ?>%</span>
                                <p class="price-sale">
                                    ₫<?php
                                        $sale_price = $related['price'] * (1 - $related['sale_percentage'] / 100);
                                        echo number_format($sale_price, 0, ',', '.'); ?>
                                </p>
                            <?php else: ?>
                                <p class="price">₫<?php echo number_format($related['price'], 0, ',', '.'); ?></p>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>