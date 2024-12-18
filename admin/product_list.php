<?php
session_start();
require '../db.php';

if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập.";
    exit;
}

// Khởi tạo các biến bộ lọc
$product_code = isset($_GET['product_code']) ? trim($_GET['product_code']) : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$product_name = isset($_GET['product_name']) ? trim($_GET['product_name']) : '';
$price_min = isset($_GET['price_min']) ? trim($_GET['price_min']) : '';
$price_max = isset($_GET['price_max']) ? trim($_GET['price_max']) : '';

// Xây dựng câu truy vấn với điều kiện lọc
$query = "SELECT * FROM products WHERE 1=1";
$params = [];

// Thêm điều kiện lọc nếu có
if ($product_code !== '') {
    $query .= " AND product_code LIKE :product_code";
    $params[':product_code'] = "%$product_code%";
}

if ($category !== '') {
    $query .= " AND category = :category";
    $params[':category'] = $category;
}

if ($product_name !== '') {
    $query .= " AND name LIKE :product_name";
    $params[':product_name'] = "%$product_name%";
}

if ($price_min !== '') {
    $query .= " AND price >= :price_min";
    $params[':price_min'] = $price_min;
}

if ($price_max !== '') {
    $query .= " AND price <= :price_max";
    $params[':price_max'] = $price_max;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Lấy danh sách các loại sản phẩm để hiển thị trong dropdown lọc
$category_stmt = $pdo->query("SELECT DISTINCT category, category_name FROM products");
$categories = $category_stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <!-- <div class="filter-group">
                    <label for="category">Loại sản phẩm:</label>
                    <select id="category" name="category">
                        <option value="">Tất cả</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat['category']); ?>" <?php if ($category === $cat['category']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($cat['category_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div> -->
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

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mã sản phẩm</th>
                        <th>Loại sản phẩm</th>
                        <th>Tên loại sản phẩm</th>
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
                            <?php
                            // Lấy danh sách ảnh phụ cho sản phẩm này
                            $img_stmt = $pdo->prepare("SELECT * FROM product_images WHERE product_id = ?");
                            $img_stmt->execute([$product['id']]);
                            $additional_images = $img_stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['id']); ?></td>
                                <td><?php echo htmlspecialchars($product['product_code']); ?></td>
                                <td><?php echo htmlspecialchars($product['category']); ?></td>
                                <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td>
                                    <!-- Ảnh chính -->
                                    <img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 50px; height: 50px;">

                                    <!-- Ảnh phụ -->
                                    <?php foreach ($additional_images as $img): ?>
                                        <img src="../uploads/<?php echo htmlspecialchars($img['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 50px; height: 50px; margin-left:5px;">
                                    <?php endforeach; ?>
                                </td>
                                <td><?php echo htmlspecialchars($product['description']); ?></td>
                                <td><?php echo number_format($product['price'], 0, ',', '.'); ?> VND</td>
                                <td><?php echo number_format($product['cost_price'], 0, ',', '.'); ?> VND</td>
                                <td><?php echo htmlspecialchars($product['stock']); ?></td>
                                <td><?php echo htmlspecialchars($product['created_at']); ?></td>
                                <td>
                                    <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn-edit">Sửa</a>
                                    <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="12">Không tìm thấy sản phẩm nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>