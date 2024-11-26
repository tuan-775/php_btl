<?php

require 'db.php';

// Truy vấn danh sách sản phẩm
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Tiêu đề trang
$pageTitle = "Trang chủ";
?>

<?php include 'header.php'; ?>

<main>
    <div class="product-container">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <a href="product_detail.php?id=<?php echo $product['id']; ?>">
                    <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p><?php echo number_format($product['price'], 0, ',', '.'); ?> VND</p>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include 'footer.php'; ?>
