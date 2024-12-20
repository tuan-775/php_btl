<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập.";
    exit;
}

require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_code = $_POST['product_code'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $sale_percentage = $_POST['sale_percentage'];
    $stock = $_POST['stock'];
    $cost_price = $_POST['cost_price'];
    $subcategory_ids = $_POST['subcategory_ids']; // Lấy danh sách loại sản phẩm

    // Upload ảnh chính
    $main_image = $_FILES['image']['name'];
    $target = "../uploads/" . basename($main_image);

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $error = "Failed to upload main image.";
    }

    // Thêm sản phẩm vào bảng `products`
    $stmt = $pdo->prepare("
        INSERT INTO products (product_code, name, description, price, sale_percentage, stock, cost_price, image) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$product_code, $name, $description, $price, $sale_percentage, $stock, $cost_price, $main_image]);

    $product_id = $pdo->lastInsertId(); // Lấy ID sản phẩm vừa thêm

    // Liên kết sản phẩm với loại sản phẩm (subcategory) qua bảng trung gian
    if (!empty($subcategory_ids)) {
        foreach ($subcategory_ids as $subcategory_id) {
            $link_stmt = $pdo->prepare("INSERT INTO product_subcategories (product_id, subcategory_id) VALUES (?, ?)");
            $link_stmt->execute([$product_id, $subcategory_id]);
        }
    }

    // Xử lý upload nhiều ảnh
    if (!empty($_FILES['additional_images']['name'][0])) {
        $additional_images = $_FILES['additional_images'];
        for ($i = 0; $i < count($additional_images['name']); $i++) {
            $filename = $additional_images['name'][$i];
            $filetmp = $additional_images['tmp_name'][$i];
            $target_additional = "../uploads/" . basename($filename);

            if (move_uploaded_file($filetmp, $target_additional)) {
                // Lưu vào bảng product_images
                $img_stmt = $pdo->prepare("INSERT INTO product_images (product_id, image_path) VALUES (?, ?)");
                $img_stmt->execute([$product_id, $filename]);
            }
        }
    }

    header("Location: product_list.php?message=Product added successfully");
    exit;
}

// Lấy danh sách danh mục cha và loại sản phẩm
$category_stmt = $pdo->query("
    SELECT c.id AS category_id, c.name AS category_name, sc.id AS subcategory_id, sc.name AS subcategory_name 
    FROM categories c
    LEFT JOIN subcategories sc ON c.id = sc.category_id
    ORDER BY c.id, sc.name
");
$data = $category_stmt->fetchAll(PDO::FETCH_ASSOC);

// Tạo một mảng nhóm loại sản phẩm theo danh mục cha
$categories = [];
foreach ($data as $row) {
    $categories[$row['category_name']][] = [
        'subcategory_id' => $row['subcategory_id'],
        'subcategory_name' => $row['subcategory_name']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <h1>Thêm sản phẩm</h1>
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="product_code">Mã sản phẩm:</label>
        <input type="text" id="product_code" name="product_code" required>

        <label for="subcategory_ids">Chọn loại sản phẩm:</label>
        <div class="checkbox-group">
            <?php foreach ($categories as $category_name => $subcategories): ?>
                <fieldset>
                    <legend><strong><?php echo htmlspecialchars($category_name); ?></strong></legend>
                    <?php foreach ($subcategories as $subcategory): ?>
                        <?php if (!empty($subcategory['subcategory_id'])): ?>
                            <label>
                                <input type="checkbox" name="subcategory_ids[]" value="<?php echo $subcategory['subcategory_id']; ?>">
                                <?php echo htmlspecialchars($subcategory['subcategory_name']); ?>
                            </label>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </fieldset>
            <?php endforeach; ?>
        </div>

        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" required>

        <label for="description">Mô tả:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" required>

        <label for="sale_percentage">Giảm giá (%):</label>
        <input type="number" id="sale_percentage" name="sale_percentage" value="0">

        <label for="stock">Số lượng tồn kho:</label>
        <input type="number" id="stock" name="stock" required>

        <label for="cost_price">Giá nhập:</label>
        <input type="number" id="cost_price" name="cost_price" required>

        <label for="image">Hình ảnh chính:</label>
        <input type="file" id="image" name="image" required>

        <label for="additional_images">Hình ảnh phụ (chọn nhiều):</label>
        <input type="file" id="additional_images" name="additional_images[]" multiple>

        <button type="submit">Thêm sản phẩm</button>
    </form>
</body>

</html>
