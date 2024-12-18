<?php
session_start();
require '../db.php';

if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập.";
    exit;
}

// Lấy các tham số lọc
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : null;
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : null;
$product_name = isset($_GET['product_name']) ? $_GET['product_name'] : null;
$product_code = isset($_GET['product_code']) ? $_GET['product_code'] : null;

// Xây dựng câu truy vấn SQL động
$sql = "
    SELECT 
        products.product_code,
        products.name AS product_name,
        products.cost_price,
        orders.quantity AS sold_quantity,
        products.price AS sale_price,
        products.sale_percentage,
        (orders.quantity * products.price * (1 - products.sale_percentage / 100)) AS total_revenue,
        ((products.price * (1 - products.sale_percentage / 100) - products.cost_price) * orders.quantity) AS total_profit
    FROM orders
    JOIN products ON orders.product_id = products.id
    WHERE 1=1
";

// Thêm điều kiện lọc vào câu truy vấn
$params = [];
if ($from_date) {
    $sql .= " AND DATE(orders.created_at) >= :from_date";
    $params['from_date'] = $from_date;
}
if ($to_date) {
    $sql .= " AND DATE(orders.created_at) <= :to_date";
    $params['to_date'] = $to_date;
}
if ($product_name) {
    $sql .= " AND products.name LIKE :product_name";
    $params['product_name'] = '%' . $product_name . '%';
}
if ($product_code) {
    $sql .= " AND products.product_code LIKE :product_code";
    $params['product_code'] = '%' . $product_code . '%';
}

$sql .= " ORDER BY orders.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$revenues = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Tính tổng doanh thu và tổng lợi nhuận
$total_revenue = 0;
$total_profit = 0;

foreach ($revenues as $revenue) {
    $total_revenue += $revenue['total_revenue'];
    $total_profit += $revenue['total_profit'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý doanh thu</title>
    <link rel="stylesheet" href="./css/inventory.css">
</head>

<body>

    <main>
        <header>
            <h1>Quản lý doanh thu</h1>
        </header>

        <a href="dashboard.php" class="back-btn">Quay lại quản trị</a>

        <!-- Form lọc doanh thu -->
        <form method="GET" action="">
            <div>
                <label for="from_date">Từ ngày:</label>
                <input type="date" id="from_date" name="from_date" value="<?php echo htmlspecialchars($from_date); ?>">

                <label for="to_date">Đến ngày:</label>
                <input type="date" id="to_date" name="to_date" value="<?php echo htmlspecialchars($to_date); ?>">
            </div>

            <div class="filter_products">
                <label for="product_name">Sản phẩm:</label>
                <input type="text" id="product_name" name="product_name" placeholder="Tên sản phẩm" value="<?php echo htmlspecialchars($product_name); ?>">

                <label for="product_code">Mã sản phẩm:</label>
                <input type="text" id="product_code" name="product_code" placeholder="Mã sản phẩm" value="<?php echo htmlspecialchars($product_code); ?>">
            </div>

            <button type="submit">Lọc</button>
        </form>

        <!-- Bảng hiển thị doanh thu -->
        <table>
            <thead>
                <tr>
                    <th>Mã sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá nhập</th>
                    <th>Giá bán</th>
                    <th>Khuyến mãi (%)</th>
                    <th>Số lượng đã bán</th>
                    <th>Doanh thu</th>
                    <th>Lợi nhuận</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($revenues)): ?>
                    <tr>
                        <td colspan="7">Không có dữ liệu phù hợp.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($revenues as $revenue): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($revenue['product_code']); ?></td>
                            <td><?php echo htmlspecialchars($revenue['product_name']); ?></td>
                            <td><?php echo number_format($revenue['cost_price'], 0, ',', '.'); ?> VND</td>
                            <td><?php echo number_format($revenue['sale_price'], 0, ',', '.'); ?> VND</td>
                            <td><?php echo htmlspecialchars($revenue['sale_percentage']); ?>%</td>
                            <td><?php echo htmlspecialchars($revenue['sold_quantity']); ?></td>
                            <td><?php echo number_format($revenue['total_revenue'], 0, ',', '.'); ?> VND</td>
                            <td><?php echo number_format($revenue['total_profit'], 0, ',', '.'); ?> VND</td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6" align="center">Tổng cộng</th>
                    <th><?php echo number_format($total_revenue, 0, ',', '.'); ?> VND</th>
                    <th><?php echo number_format($total_profit, 0, ',', '.'); ?> VND</th>
                </tr>
            </tfoot>
        </table>
    </main>
</body>

</html>