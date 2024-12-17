<?php
require 'db.php';
session_start();

// Lấy tên bộ sưu tập từ URL
$collection = isset($_GET['collection']) ? trim($_GET['collection']) : '';

// Số sản phẩm mỗi trang
$items_per_page = 20;

// Kiểm tra xem bộ sưu tập có hợp lệ không
if (!empty($collection)) {
    // Truy vấn tổng số sản phẩm trong bộ sưu tập
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE FIND_IN_SET(:collection, category) > 0");
    $stmt->bindValue(':collection', $collection, PDO::PARAM_STR);
    $stmt->execute();
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

    // Truy vấn sản phẩm trong bộ sưu tập với phân trang
    $stmt = $pdo->prepare("SELECT * FROM products WHERE FIND_IN_SET(:collection, category) > 0 LIMIT :offset, :limit");
    $stmt->bindValue(':collection', $collection, PDO::PARAM_STR);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT); // OFFSET
    $stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT); // LIMIT
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Nếu không có thông tin bộ sưu tập hợp lệ
    die("Vui lòng chọn bộ sưu tập hợp lệ.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($collection); ?></title>
    <link rel="stylesheet" href="./css/sale.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <?php include './header.php'; ?>

    <main>
        <div class="breadcrumb">
            <a href="index.php">Trang chủ</a> /
            <span><?php echo htmlspecialchars($collection); ?></span>
        </div>

        <?php if (empty($products)): ?>
            <p>Không có sản phẩm nào trong bộ sưu tập này.</p>
        <?php else: ?>
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
                                            echo number_format($sale_price, 0, ',', '.'); ?>
                                        <span class="sale-percentage">-<?php echo htmlspecialchars($product['sale_percentage']); ?>%</span>
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
        <?php endif; ?>

        <!-- Phân trang -->
        <div class="pagination">
            <ul>
                <?php if ($current_page > 1): ?>
                    <li><a href="?collection=<?php echo urlencode($collection); ?>&page=1">Đầu</a></li>
                    <li><a href="?collection=<?php echo urlencode($collection); ?>&page=<?php echo $current_page - 1; ?>">«</a></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="<?php echo $i == $current_page ? 'active' : ''; ?>">
                        <a href="?collection=<?php echo urlencode($collection); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                    <li><a href="?collection=<?php echo urlencode($collection); ?>&page=<?php echo $current_page + 1; ?>">»</a></li>
                    <li><a href="?collection=<?php echo urlencode($collection); ?>&page=<?php echo $total_pages; ?>">Cuối</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </main>

    <?php include './footer.php'; ?>
</body>

</html>