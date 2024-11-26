<?php
require 'db.php';
session_start();

// Lấy từ khóa từ form tìm kiếm
$query = isset($_GET['query']) ? trim($_GET['query']) : '';

// Tìm kiếm trong cơ sở dữ liệu
if ($query) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE ?");
    $stmt->execute(["%$query%"]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $products = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; ?>

<main>
    <h1>Kết quả tìm kiếm cho: "<?php echo htmlspecialchars($query); ?>"</h1>

    <?php if (empty($products)): ?>
        <p>Không tìm thấy sản phẩm nào.</p>
    <?php else: ?>
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
    <?php endif; ?>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
