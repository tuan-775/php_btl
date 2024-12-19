<?php
require 'db.php';
session_start();

// Số sản phẩm mỗi trang
$items_per_page = 6;

// Lấy danh mục từ URL
$category_name = isset($_GET['category_name']) ? trim($_GET['category_name']) : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';

// Truy vấn tổng số sản phẩm trong danh mục
if (!empty($category_name) && !empty($category)) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE category LIKE CONCAT('%', :category, '%') AND category_name = :category_name");
    $stmt->execute([':category' => $category, ':category_name' => $category_name]);
} elseif (!empty($category)) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE category LIKE CONCAT('%', :category, '%')");
    $stmt->execute([':category' => $category]);
} else {
    die("Vui lòng chọn danh mục hợp lệ.");
}

// Lấy tổng số sản phẩm
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

// Truy vấn sản phẩm cho trang hiện tại (bổ sung LIMIT và OFFSET)
if (!empty($category_name) && !empty($category)) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category LIKE CONCAT('%', :category, '%') AND category_name = :category_name LIMIT :offset, :limit");
    $stmt->bindValue(':category', $category);
    $stmt->bindValue(':category_name', $category_name);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
    $stmt->execute();
} elseif (!empty($category)) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category LIKE CONCAT('%', :category, '%') LIMIT :offset, :limit");
    $stmt->bindValue(':category', $category);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
    $stmt->execute();
} else {
    die("Vui lòng chọn danh mục hợp lệ.");
}

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                                    <?php if ($product['sale_percentage'] > 0): ?>
                                        <div class="price-sale">
                                            ₫<?php
                                                $sale_price = $product['price'] * (1 - $product['sale_percentage'] / 100);
                                                echo number_format($sale_price, 0, ',', '.'); ?> <span class="sale-percentage">-<?php echo htmlspecialchars($product['sale_percentage']); ?>%</span>
                                        </div>
                                    <?php else: ?>
                                        <p class="price">₫<?php echo number_format($product['price'], 0, ',', '.'); ?></p>
                                    <?php endif; ?>
                                </p>
                                <div class="sold-quantity">Đã bán: <?php echo number_format($product['sold_quantity'], 0, ',', '.'); ?></div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Phân trang -->
        <div class="pagination">
            <ul>
                <?php if ($current_page > 1): ?>
                    <li><a href="?category=<?php echo urlencode($category); ?>&page=1">Đầu</a></li>
                    <li><a href="?category=<?php echo urlencode($category); ?>&page=<?php echo $current_page - 1; ?>">«</a></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="<?php echo $i == $current_page ? 'active' : ''; ?>">
                        <a href="?category=<?php echo urlencode($category); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

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