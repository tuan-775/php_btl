<?php
session_start();
require '../db.php';

if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập.";
    exit;
}

// Lấy danh sách doanh thu từ bảng products
$stmt = $pdo->query("
    SELECT 
        products.name AS product_name,
        products.cost_price,
        products.price AS sale_price,
        products.sale_percentage,
        products.stock,
        products.sold_quantity,
        -- Tính doanh thu đã bao gồm khuyến mãi
        (products.sold_quantity * products.price * (1 - products.sale_percentage / 100)) AS total_revenue,
        -- Tính lợi nhuận sau khi trừ giá vốn và khuyến mãi
        ((products.price * (1 - products.sale_percentage / 100) - products.cost_price) * products.sold_quantity) AS total_profit
    FROM products
    ORDER BY products.name
");
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
    <!-- <link rel="stylesheet" href="../css/product_list.css"> -->
    <link rel="stylesheet" href="./css/inventory.css">

</head>

<body>
    <header>
        <h1>Quản lý doanh thu</h1>
    </header>
    <main>
        <a href="dashboard.php" class="back-btn">Quay lại quản trị</a>
        <table>
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Giá nhập</th>
                    <th>Giá bán</th>
                    <th>Khuyến mãi (%)</th>
                    <th>Số lượng đã bán</th>
                    <th>Số hàng còn lại</th>
                    <th>Doanh thu</th>
                    <th>Lợi nhuận</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($revenues as $revenue): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($revenue['product_name']); ?></td>
                        <td><?php echo number_format($revenue['cost_price'], 0, ',', '.'); ?> VND</td>
                        <td><?php echo number_format($revenue['sale_price'], 0, ',', '.'); ?> VND</td>
                        <td><?php echo htmlspecialchars($revenue['sale_percentage']); ?>%</td>
                        <td><?php echo htmlspecialchars($revenue['sold_quantity']); ?></td>
                        <td><?php echo htmlspecialchars($revenue['stock']); ?></td>
                        <td><?php echo number_format($revenue['total_revenue'], 0, ',', '.'); ?> VND</td>
                        <td><?php echo number_format($revenue['total_profit'], 0, ',', '.'); ?> VND</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6">Tổng cộng</th>
                    <th><?php echo number_format($total_revenue, 0, ',', '.'); ?> VND</th>
                    <th><?php echo number_format($total_profit, 0, ',', '.'); ?> VND</th>
                </tr>
            </tfoot>
        </table>
    </main>
</body>

</html>