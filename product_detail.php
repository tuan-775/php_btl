<?php
require 'db.php';
session_start();

// Lấy ID sản phẩm
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Lấy thông tin sản phẩm
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Sản phẩm không tồn tại.");
}

// Lấy ảnh phụ
$img_stmt = $pdo->prepare("SELECT image_path FROM product_images WHERE product_id = ?");
$img_stmt->execute([$product_id]);
$productImages = $img_stmt->fetchAll(PDO::FETCH_ASSOC);

// Danh sách size kèm cân nặng
$sizeOptions = [
    ['value' => '2Y',  'label' => '2Y-11-12kg'],
    ['value' => '4Y',  'label' => '4Y-14-16kg'],
    ['value' => '6Y',  'label' => '6Y-19-21kg'],
    ['value' => '8Y',  'label' => '8Y-23-25kg'],
    ['value' => '10Y', 'label' => '10Y-27-31kg'],
    ['value' => '12Y', 'label' => '12Y-33-35kg'],
];

// Sản phẩm liên quan
$related_products_stmt = $pdo->prepare("
    SELECT * FROM products 
    WHERE category = ? AND category_name = ? AND id != ?
    LIMIT 4
");
$related_products_stmt->execute([$product['category'], $product['category_name'], $product_id]);
$related_products = $related_products_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
    <link rel="stylesheet" href="./css/product_detail.css">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'header.php'; ?>
    <main>
        <section>
            <div class="infomation_product">
                <div class="main-image">
                    <img id='main-product-image' src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" width="300"><br><br>

                    <!-- Ảnh chính trong thumbnail -->
                    <img id='thumbnail-image' src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="Ảnh chính" width="50" style="cursor:pointer;" onclick="changeMainImage(this.src)">

                    <!-- Ảnh phụ -->
                    <?php foreach ($productImages as $img): ?>
                        <img src="uploads/<?php echo htmlspecialchars($img['image_path']); ?>" alt="Ảnh phụ" width="50" style="cursor:pointer;" onclick="changeMainImage(this.src)">
                    <?php endforeach; ?>
                </div>

                <div class="infomation">
                    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                    <div class="price">₫<?php echo number_format($product['price'], 0, ',', '.'); ?> </div>
                    <p><strong>Mã sản phẩm:</strong> <?php echo htmlspecialchars($product['product_code']); ?></p>
                    <p><strong>Mô tả:</strong> <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>

                    <!-- Chỉ hiển thị chọn kích thước nếu category_name không phải là "Phụ kiện" -->
                    <?php if ($product['category_name'] !== 'Phụ kiện'): ?>
                        <p><strong>Kích thước:</strong></p>
                        <form action="cart/add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                            <?php foreach ($sizeOptions as $opt): ?>
                                <label id='size' style="display:inline-block; margin-right:10px;margin-bottom:10px; border:1px solid #ccc; padding:5px;">
                                    <input type="radio" name="selected_size" value="<?php echo htmlspecialchars($opt['value']); ?>">
                                    <?php echo htmlspecialchars($opt['label']); ?>
                                </label>
                            <?php endforeach; ?>

                            <br><br>
                            <label id='quantity'>Số lượng: <input type="number" name="quantity" value="1" min="1"></label>
                            <br><br>

                            <?php if (isset($_SESSION['user_id'])): ?>
                                <button type="submit" id='add-to-cart' name="add_to_cart">Thêm vào giỏ hàng</button>
                            <?php else: ?>
                                <div>
                                    <i class="fas fa-exclamation-circle"></i>
                                    Vui lòng <a href="login/login.php">đăng nhập</a> để thêm sản phẩm vào giỏ hàng!
                                </div>
                            <?php endif; ?>
                        </form>
                    <?php else: ?>
                        
                        <form action="cart/add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <label id='quantity'>Số lượng: <input type="number" name="quantity" value="1" min="1"></label>
                            <br><br>

                            <?php if (isset($_SESSION['user_id'])): ?>
                                <button type="submit" id='add-to-cart' name="add_to_cart">Thêm vào giỏ hàng</button>
                            <?php else: ?>
                                <div>
                                    <i class="fas fa-exclamation-circle"></i>
                                    Vui lòng <a href="login/login.php">đăng nhập</a> để thêm sản phẩm vào giỏ hàng!
                                </div>
                            <?php endif; ?>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="relate">
            <div class="related-products">
                <h2>Sản phẩm liên quan</h2>
                <div class="related-products-container">
                    <?php foreach ($related_products as $related): ?>
                        <div class="product-card">
                            <a href="product_detail.php?id=<?php echo $related['id']; ?>">
                                <img src="uploads/<?php echo htmlspecialchars($related['image']); ?>" alt="<?php echo htmlspecialchars($related['name']); ?>">
                                <h3><?php echo htmlspecialchars($related['name']); ?></h3>
                                <?php if ($related['sale_percentage'] > 0): ?>
                                    <span class="sale-percentage">Giảm <?php echo htmlspecialchars($related['sale_percentage']); ?>%</span>
                                    <p class="price-sale">
                                        ₫<?php
                                            $sale_price = $related['price'] * (1 - $related['sale_percentage'] / 100);
                                            echo number_format($sale_price, 0, ',', '.'); ?>
                                    </p>
                                <?php else: ?>
                                    <p class="price">₫<?php echo number_format($related['price'], 0, ',', '.'); ?></p>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>
    <?php include 'footer.php'; ?>

    <script>
        function changeMainImage(src) {
            document.getElementById('main-product-image').src = src;
        }
</body>

</html>
