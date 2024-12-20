<?php
session_start();
require '../db.php';

// Kiểm tra quyền truy cập
if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập.";
    exit;
}

// Khởi tạo các biến bộ lọc
$product_code = isset($_GET['product_code']) ? trim($_GET['product_code']) : '';
$subcategory = isset($_GET['subcategory']) ? trim($_GET['subcategory']) : '';
$product_name = isset($_GET['product_name']) ? trim($_GET['product_name']) : '';
$price_min = isset($_GET['price_min']) ? trim($_GET['price_min']) : '';
$price_max = isset($_GET['price_max']) ? trim($_GET['price_max']) : '';

// Xây dựng câu truy vấn với điều kiện lọc
$query = "
SELECT 
    p.id AS product_id,
    p.product_code,
    p.name AS product_name,
    p.image,
    p.description,
    p.price,
    p.cost_price,
    p.stock,
    p.created_at,
    GROUP_CONCAT(DISTINCT CONCAT(c.name, ': ', sc.name) SEPARATOR ', ') AS subcategories -- Gộp danh mục và loại sản phẩm
FROM 
    products p
LEFT JOIN 
    product_subcategories ps ON p.id = ps.product_id
LEFT JOIN 
    subcategories sc ON ps.subcategory_id = sc.id
LEFT JOIN 
    categories c ON sc.category_id = c.id
WHERE 
    1=1
";
$params = [];

// Thêm điều kiện lọc nếu có
if ($product_code !== '') {
    $query .= " AND p.product_code LIKE :product_code";
    $params[':product_code'] = "%$product_code%";
}

if ($subcategory !== '') {
    $query .= " AND sc.id = :subcategory_id";
    $params[':subcategory_id'] = $subcategory;
}

if ($product_name !== '') {
    $query .= " AND p.name LIKE :product_name";
    $params[':product_name'] = "%$product_name%";
}

if ($price_min !== '') {
    $query .= " AND p.price >= :price_min";
    $params[':price_min'] = $price_min;
}

if ($price_max !== '') {
    $query .= " AND p.price <= :price_max";
    $params[':price_max'] = $price_max;
}

$query .= " GROUP BY p.id"; // Gộp theo từng sản phẩm

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Lấy danh sách các loại sản phẩm từ bảng `subcategories`
$subcategory_stmt = $pdo->query("SELECT id, name FROM subcategories");
$subcategories = $subcategory_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link rel="stylesheet" href="./css/product_list.css">
</head>

<body>
    <header>
        <h1>Danh sách sản phẩm</h1>
    </header>
    <main>
        <div class="back">
            <a href="dashboard.php" class="back-btn">Quay lại quản trị</a>
            <a href="add_product.php" class="add-btn">Thêm sản phẩm mới</a>
        </div>

        <!-- Form Bộ Lọc -->
        <div class="filter-container">
            <form method="GET" action="product_list.php">
                <div class="filter-group">
                    <label for="product_code">Mã sản phẩm:</label>
                    <input type="text" id="product_code" name="product_code" value="<?php echo htmlspecialchars($product_code); ?>">
                </div>
                <div class="filter-group">
                    <label for="subcategory">Loại sản phẩm:</label>
                    <select id="subcategory" name="subcategory">
                        <option value="">Tất cả</option>
                        <?php foreach ($subcategories as $sub): ?>
                            <option value="<?php echo htmlspecialchars($sub['id']); ?>" <?php if ($subcategory === $sub['id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($sub['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="product_name">Tên sản phẩm:</label>
                    <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>">
                </div>
                <div class="filter-group">
                    <label for="price_min">Giá bán từ:</label>
                    <input type="number" id="price_min" name="price_min" min="0" value="<?php echo htmlspecialchars($price_min); ?>">
                </div>
                <div class="filter-group">
                    <label for="price_max">Giá bán đến:</label>
                    <input type="number" id="price_max" name="price_max" min="0" value="<?php echo htmlspecialchars($price_max); ?>">
                </div>
                <div class="filter-actions">
                    <button type="submit" class="filter-btn">Lọc</button>
                    <a href="product_list.php" class="reset-btn">Reset</a>
                </div>
            </form>
        </div>

        <!-- Bảng danh sách sản phẩm -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mã sản phẩm</th>
                        <th>Loại sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Mô tả</th>
                        <th>Giá bán</th>
                        <th>Giá nhập</th>
                        <th>Tồn kho</th>
                        <th>Ngày thêm</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($products) > 0): ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                                <td><?php echo htmlspecialchars($product['product_code']); ?></td>
                                <td><?php echo htmlspecialchars($product['subcategories']); ?></td> <!-- Hiển thị danh mục và loại sản phẩm -->
                                <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                                <td>
                                    <img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" style="width: 50px; height: 50px;">
                                </td>
                                <td><?php echo htmlspecialchars($product['description']); ?></td>
                                <td><?php echo number_format($product['price'], 0, ',', '.'); ?> VND</td>
                                <td><?php echo number_format($product['cost_price'], 0, ',', '.'); ?> VND</td>
                                <td><?php echo htmlspecialchars($product['stock']); ?></td>
                                <td><?php echo htmlspecialchars($product['created_at']); ?></td>
                                <td>
                                    <a href="edit_product.php?id=<?php echo $product['product_id']; ?>" class="btn-edit">Sửa</a>
                                    <a href="delete_product.php?id=<?php echo $product['product_id']; ?>" class="btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="11">Không tìm thấy sản phẩm nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>
