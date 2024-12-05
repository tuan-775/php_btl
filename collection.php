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
    <link rel="stylesheet" href="css/style.css">
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