<?php
require 'db.php';
session_start();

// Lấy danh mục con từ URL
// Lấy danh mục con (category_name)
$category_name = isset($_GET['category_name']) ? trim($_GET['category_name']) : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';

if (!empty($category_name)) {
    // Nếu có cả `category` và `category_name`
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category = ? AND category_name = ?");
    $stmt->execute([$category, $category_name]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif (!empty($category)) {
    // Nếu chỉ có `category`
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category = ?");
    $stmt->execute([$category]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Không có thông tin danh mục hợp lệ
    die("Vui lòng chọn danh mục hợp lệ.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($category_name); ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; ?>

<main>
    <h1>Sản phẩm thuộc: <?php echo htmlspecialchars($category . ' > ' . $category_name); ?></h1>

    <?php if (empty($products)): ?>
        <p>Không có sản phẩm nào trong danh mục này.</p>
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
