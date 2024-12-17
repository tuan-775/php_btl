<?php
session_start();
require 'db.php';

// Số sản phẩm mỗi trang
$items_per_page = 12;

// Lấy tổng số sản phẩm
$stmt = $pdo->query("SELECT COUNT(*) FROM products");
$total_items = $stmt->fetchColumn();

// Lấy số trang hiện tại từ URL, mặc định là trang 1
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// Tính số trang
$total_pages = ceil($total_items / $items_per_page);

// Kiểm tra số trang hợp lệ
if ($current_page < 1) {
    $current_page = 1;
} elseif ($current_page > $total_pages) {
    $current_page = $total_pages;
}

// Tính toán offset (vị trí bắt đầu lấy dữ liệu)
$offset = ($current_page - 1) * $items_per_page;

// Lấy danh sách sản phẩm cho trang hiện tại
$stmt = $pdo->prepare("SELECT * FROM products ORDER BY created_at DESC LIMIT :offset, :limit");
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="./css/index.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'header.php'; ?>
    <main>
        <?php include 'banner.php' ?>
        <!-- Danh sách sản phẩm -->
        <div class="product">
            <div class="product-container">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <a href="product_detail.php?id=<?php echo $product['id']; ?>">
                            <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <?php if ($product['sale_percentage'] > 0): ?>
                                <div class="price-sale">
                                    ₫<?php
                                        $sale_price = $product['price'] * (1 - $product['sale_percentage'] / 100);
                                        echo number_format($sale_price, 0, ',', '.'); ?> <span class="sale-percentage">-<?php echo htmlspecialchars($product['sale_percentage']); ?>%</span>
                                </div>
                            <?php else: ?>
                                <p class="price">₫<?php echo number_format($product['price'], 0, ',', '.'); ?></p>
                            <?php endif; ?>

                            <!-- Hiển thị số lượng đã bán -->
                            <div class="sold-quantity">Đã bán: <?php echo number_format($product['sold_quantity'], 0, ',', '.'); ?></div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Phân trang -->
        <div class="pagination">
            <ul>
                <?php if ($current_page > 1): ?>
                    <li><a href="?page=1">Đầu</a></li>
                    <li><a href="?page=<?php echo $current_page - 1; ?>">«</a></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="<?php echo $i == $current_page ? 'active' : ''; ?>">
                        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                    <li><a href="?page=<?php echo $current_page + 1; ?>">»</a></li>
                    <li><a href="?page=<?php echo $total_pages; ?>">Cuối</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>

</html>