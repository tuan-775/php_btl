<?php
require 'db.php';
session_start();

// Lấy thông tin filter từ URL
$category = isset($_GET['category']) ? $_GET['category'] : '';
$sale_range = isset($_GET['sale_range']) ? $_GET['sale_range'] : '';

// Số sản phẩm mỗi trang
$items_per_page = 20;

// Tạo câu query cơ bản
$query = "SELECT * FROM products WHERE sale_percentage > 0";
$params = [];

// Thêm điều kiện lọc theo danh mục (nếu có)
if ($category) {
    $query .= " AND category = ?";
    $params[] = $category;
}

// Thêm điều kiện lọc theo khoảng giảm giá
if ($sale_range) {
    if ($sale_range == '10-25') {
        $query .= " AND sale_percentage BETWEEN 10 AND 25";
    } elseif ($sale_range == '25-50') {
        $query .= " AND sale_percentage BETWEEN 25 AND 50";
    }
}

// Truy vấn tổng số sản phẩm để tính số trang
$count_query = $query; // Sử dụng lại query ban đầu (không có LIMIT)
$count_stmt = $pdo->prepare($count_query);
$count_stmt->execute($params);
$total_items = $count_stmt->fetchColumn();

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

// Cập nhật query để lấy sản phẩm với LIMIT và OFFSET
$query .= " LIMIT $offset, $items_per_page";  // Thay thế :offset và :limit bằng giá trị trực tiếp

// Thực thi câu query với LIMIT và OFFSET
$stmt = $pdo->prepare($query);
$stmt->execute($params);

// Lấy các sản phẩm từ cơ sở dữ liệu
$sale_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SALE</title>
    <link rel="stylesheet" href="./css/sale.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <main>
        <nav class="breadcrumb">
            <a href="index.php">Trang chủ</a> /
            <span>
                <?php
                if (isset($_GET['sale_range']) && $_GET['sale_range'] === '10-25') {
                    echo "Sale 10%-25%";
                } elseif (isset($_GET['sale_range']) && $_GET['sale_range'] == '25-50') {
                    echo "Sale 25%-50%";
                } elseif (isset($_GET['category']) && $_GET['category'] == 'girls') {
                    echo "Sale Bé Gái";
                } elseif (isset($_GET['category']) && $_GET['category'] == 'boys') {
                    echo "Sale Bé Trai";
                } else {
                    echo "Sale";
                }
                ?>
            </span>
        </nav>

        <h1>SALE</h1>
        <div class="product">
            <!-- Hiển thị sản phẩm -->
            <div class="product-container">
                <?php if (count($sale_products) > 0): ?>
                    <?php foreach ($sale_products as $product): ?>
                        <div class="product-card">
                            <a href="product_detail.php?id=<?php echo $product['id']; ?>">
                                <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                                <?php if ($product['sale_percentage'] > 0): ?>

                                    <p class="price-sale">
                                        ₫<?php
                                            $sale_price = $product['price'] * (1 - $product['sale_percentage'] / 100);
                                            echo number_format($sale_price, 0, ',', '.'); ?> <span class="sale-percentage">Giảm <?php echo htmlspecialchars($product['sale_percentage']); ?>%</span>
                                    </p>
                                <?php else: ?>
                                    <p class="price">₫<?php echo number_format($product['price'], 0, ',', '.'); ?></p>
                                <?php endif; ?>
                                <div class="sold-quantity">Đã bán: <?php echo number_format($product['sold_quantity'], 0, ',', '.'); ?></div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Không có sản phẩm nào trong danh mục này.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Hiển thị phân trang -->
        <div class="pagination">
            <ul>
                <!-- Liên kết đến trang đầu -->
                <?php if ($current_page > 1): ?>
                    <li><a href="?category=<?php echo urlencode($category); ?>&sale_range=<?php echo urlencode($sale_range); ?>&page=1">Đầu</a></li>
                    <li><a href="?category=<?php echo urlencode($category); ?>&sale_range=<?php echo urlencode($sale_range); ?>&page=<?php echo $current_page - 1; ?>">«</a></li>
                <?php endif; ?>

                <!-- Liên kết đến các trang giữa -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="<?php echo $i == $current_page ? 'active' : ''; ?>">
                        <a href="?category=<?php echo urlencode($category); ?>&sale_range=<?php echo urlencode($sale_range); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Liên kết đến trang tiếp theo -->
                <?php if ($current_page < $total_pages): ?>
                    <li><a href="?category=<?php echo urlencode($category); ?>&sale_range=<?php echo urlencode($sale_range); ?>&page=<?php echo $current_page + 1; ?>">»</a></li>
                    <li><a href="?category=<?php echo urlencode($category); ?>&sale_range=<?php echo urlencode($sale_range); ?>&page=<?php echo $total_pages; ?>">Cuối</a></li>
                <?php endif; ?>
            </ul>
        </div>

    </main>

    <?php include 'footer.php'; ?>
</body>

</html>