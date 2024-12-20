<?php
require 'db.php';
session_start();

// Số sản phẩm mỗi trang
$items_per_page = 6;

// Lấy danh mục từ URL
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
$subcategory_id = isset($_GET['subcategory_id']) ? intval($_GET['subcategory_id']) : 0;

// Truy vấn tên danh mục
$category_name = '';
if ($category_id) {
    $stmt = $pdo->prepare("SELECT name FROM categories WHERE id = ?");
    $stmt->execute([$category_id]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
    $category_name = $category ? $category['name'] : '';
}

// Truy vấn tên loại sản phẩm
$subcategory_name = '';
if ($subcategory_id) {
    $stmt = $pdo->prepare("SELECT name FROM subcategories WHERE id = ?");
    $stmt->execute([$subcategory_id]);
    $subcategory = $stmt->fetch(PDO::FETCH_ASSOC);
    $subcategory_name = $subcategory ? $subcategory['name'] : '';
}

// Kiểm tra xem category_id hoặc subcategory_id có hợp lệ không
if (!$category_id && !$subcategory_id) {
    die("Vui lòng chọn danh mục hoặc loại sản phẩm hợp lệ.");
}

// Truy vấn tổng số sản phẩm trong danh mục hoặc loại sản phẩm
if ($subcategory_id) {
    $stmt = $pdo->prepare("
        SELECT COUNT(DISTINCT p.id) 
        FROM products p
        INNER JOIN product_subcategories ps ON p.id = ps.product_id
        WHERE ps.subcategory_id = ?
    ");
    $stmt->execute([$subcategory_id]);
} elseif ($category_id) {
    $stmt = $pdo->prepare("
        SELECT COUNT(DISTINCT p.id) 
        FROM products p
        INNER JOIN product_subcategories ps ON p.id = ps.product_id
        INNER JOIN subcategories sc ON ps.subcategory_id = sc.id
        WHERE sc.category_id = ?
    ");
    $stmt->execute([$category_id]);
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

// Truy vấn sản phẩm cho trang hiện tại
if ($subcategory_id) {
    $stmt = $pdo->prepare("
        SELECT p.* 
        FROM products p
        INNER JOIN product_subcategories ps ON p.id = ps.product_id
        WHERE ps.subcategory_id = :subcategory_id
        LIMIT :offset, :limit
    ");
    $stmt->bindValue(':subcategory_id', $subcategory_id, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
    $stmt->execute();
} elseif ($category_id) {
    $stmt = $pdo->prepare("
        SELECT p.* 
        FROM products p
        INNER JOIN product_subcategories ps ON p.id = ps.product_id
        INNER JOIN subcategories sc ON ps.subcategory_id = sc.id
        WHERE sc.category_id = :category_id
        LIMIT :offset, :limit
    ");
    $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
    $stmt->execute();
}

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($subcategory_id ? $subcategory_name : $category_name); ?></title>
    <link rel="stylesheet" href="./css/category.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <main>
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="index.php">Trang chủ</a>
            <?php if ($category_id): ?>
                / <a href="category.php?category_id=<?php echo urlencode($category_id); ?>">
                    <?php echo htmlspecialchars($category_name); ?>
                </a>
            <?php endif; ?>
            <?php if ($subcategory_id): ?>
                / <span><?php echo htmlspecialchars($subcategory_name); ?></span>
            <?php endif; ?>
        </div>

        <!-- Danh sách sản phẩm -->
        <?php if (empty($products)): ?>
            <p>Không có sản phẩm nào trong danh mục hoặc loại sản phẩm này.</p>
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
                    <li><a href="?<?php echo $category_id ? 'category_id=' . urlencode($category_id) : 'subcategory_id=' . urlencode($subcategory_id); ?>&page=1">Đầu</a></li>
                    <li><a href="?<?php echo $category_id ? 'category_id=' . urlencode($category_id) : 'subcategory_id=' . urlencode($subcategory_id); ?>&page=<?php echo $current_page - 1; ?>">«</a></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="<?php echo $i == $current_page ? 'active' : ''; ?>">
                        <a href="?<?php echo $category_id ? 'category_id=' . urlencode($category_id) : 'subcategory_id=' . urlencode($subcategory_id); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                    <li><a href="?<?php echo $category_id ? 'category_id=' . urlencode($category_id) : 'subcategory_id=' . urlencode($subcategory_id); ?>&page=<?php echo $current_page + 1; ?>">»</a></li>
                    <li><a href="?<?php echo $category_id ? 'category_id=' . urlencode($category_id) : 'subcategory_id=' . urlencode($subcategory_id); ?>&page=<?php echo $total_pages; ?>">Cuối</a></li>
                <?php endif; ?>
            </ul>
        </div>

    </main>

    <?php include 'footer.php'; ?>
</body>

</html>
