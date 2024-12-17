<?php
require 'db.php';
session_start();

// Kiểm tra category được truyền qua URL và tránh SQL Injection
$category = isset($_GET['category']) ? trim($_GET['category']) : '';

// Số sản phẩm mỗi trang
$items_per_page = 6;

// Lấy tổng số sản phẩm trong danh mục (nếu có category)
if ($category) {
    // Truy vấn tổng số sản phẩm trong danh mục
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE category = :category");
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    $stmt->execute();
} else {
    // Truy vấn tổng số sản phẩm trong tất cả danh mục
    $stmt = $pdo->query("SELECT COUNT(*) FROM products");
}
$total_items = $stmt->fetchColumn();

// Tính số trang
$total_pages = ceil($total_items / $items_per_page);

// Lấy số trang hiện tại từ URL, mặc định là trang 1
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Kiểm tra số trang hợp lệ
if ($current_page < 1) {
    $current_page = 1;
} elseif ($current_page > $total_pages) {
    $current_page = $total_pages;
}

// Tính toán offset (vị trí bắt đầu lấy dữ liệu)
$offset = ($current_page - 1) * $items_per_page;

// Lấy sản phẩm theo category và phân trang
if ($category) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category = :category ORDER BY created_at DESC LIMIT :offset, :limit");
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $items_per_page, PDO::PARAM_INT);
    $stmt->execute();
} else {
    $stmt = $pdo->prepare("SELECT * FROM products ORDER BY created_at DESC LIMIT :offset, :limit");
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $items_per_page, PDO::PARAM_INT);
    $stmt->execute();
}

$new_arrivals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Arrival - <?php echo htmlspecialchars($category ?: 'Tất cả'); ?></title>
    <link rel="stylesheet" href="./css/sale.css">
    <link rel="stylesheet" href="./css/style.css">
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
                            <p class="price">₫<?php echo number_format($product['price'], 0, ',', '.'); ?></p>
                            <div class="sold-quantity">Đã bán: <?php echo number_format($product['sold_quantity'], 0, ',', '.'); ?></div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Không có sản phẩm nào trong danh mục này.</p>
            <?php endif; ?>
        </div>

        <!-- Hiển thị phân trang -->
        <div class="pagination">
            <ul>
                <!-- Liên kết đến trang đầu -->
                <?php if ($current_page > 1): ?>
                    <li><a href="?category=<?php echo urlencode($category); ?>&page=1">Đầu</a></li>
                    <li><a href="?category=<?php echo urlencode($category); ?>&page=<?php echo $current_page - 1; ?>">«</a></li>
                <?php endif; ?>

                <!-- Liên kết đến các trang giữa -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="<?php echo $i == $current_page ? 'active' : ''; ?>">
                        <a href="?category=<?php echo urlencode($category); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Liên kết đến trang tiếp theo -->
                <?php if ($current_page < $total_pages): ?>
                    <li><a href="?category=<?php echo urlencode($category); ?>&page=<?php echo $current_page + 1; ?>">»</a></li>
                    <li><a href="?category=<?php echo urlencode($category); ?>&page=<?php echo $total_pages; ?>">Cuối</a></li>
                <?php endif; ?>
            </ul>
        </div>

    </main>

    <?php include 'footer.php'; ?>
</body>

</html>