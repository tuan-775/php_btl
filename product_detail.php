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
// Truy vấn các đánh giá sản phẩm cùng với thông tin người dùng
$stmt_reviews = $pdo->prepare("
    SELECT product_reviews.*, users.fullname AS user_name 
    FROM product_reviews 
    JOIN users ON product_reviews.user_id = users.id 
    WHERE product_reviews.product_id = ?");
$stmt_reviews->execute([$product_id]);
$reviews = $stmt_reviews->fetchAll(PDO::FETCH_ASSOC);
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
                    <div class="thumbnail">
                        <img id='thumbnail-image' src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="Ảnh chính" width="50" style="cursor:pointer;" onclick="changeMainImage(this.src)">

                        <!-- Ảnh phụ -->
                        <?php foreach ($productImages as $img): ?>
                            <img id='thumbnail-image' src="uploads/<?php echo htmlspecialchars($img['image_path']); ?>" alt="Ảnh phụ" width="50" style="cursor:pointer;" onclick="changeMainImage(this.src)">
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="infomation">
                    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                    <div class="price">₫
                        <?php echo number_format($product['price'], 0, ',', '.'); ?> </div>
                    <p><strong>Mã sản phẩm:</strong> <?php echo htmlspecialchars($product['product_code']); ?></p>
                    <p><strong>Mô tả:</strong> <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>

                    <!-- Chỉ hiển thị chọn kích thước nếu category_name không phải là "Phụ kiện" -->
                    <?php if ($product['category_name'] !== 'Phụ kiện'): ?>
                        <p><strong>Kích thước:</strong></p>
                        <form action="cart/add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                            <?php foreach ($sizeOptions as $opt): ?>
                                <label id='size' style="display:inline-block; margin-right:10px;margin-bottom:10px; border:1px solid #ccc; padding:5px;">
                                    <input type="radio" name="selected_size" required value="<?php echo htmlspecialchars($opt['value']); ?>">
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
                    <!-- Hiển thị đánh giá sản phẩm -->
                    <h2>Đánh giá sản phẩm</h2>

                    <button id="toggleReviewsBtn">Xem tất cả đánh giá</button>

                    <div class="reviews-container" id="reviewsContainer">
                        <?php foreach ($reviews as $review): ?>
                            <div class="review-item">
                                <div class="review-header">
                                    <span class="review-user"><?php echo htmlspecialchars($review['user_name']); ?></span> 
                                    <span class="review-rating">Đánh giá: <?php echo $review['rating']; ?>/5 sao</span>
                                    <span class="review-date"><?php echo date("d/m/Y", strtotime($review['created_at'])); ?></span>
                                </div>
                                <div class="review-body">
                                    <p class="review-text"><?php echo nl2br(htmlspecialchars($review['review'])); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
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

                                    <p class="price-sale">
                                        ₫<?php
                                            $sale_price = $related['price'] * (1 - $related['sale_percentage'] / 100);
                                            echo number_format($sale_price, 0, ',', '.'); ?> <span class="sale-percentage">Giảm <?php echo htmlspecialchars($related['sale_percentage']); ?>%</span>
                                    </p>
                                <?php else: ?>
                                    <p class="price">₫<?php echo number_format($related['price'], 0, ',', '.'); ?></p>
                                <?php endif; ?>

                                <div class="sold-quantity">Đã bán: <?php echo number_format($product['sold_quantity'], 0, ',', '.'); ?></div>
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
    </script>
    <script>
        // Hiển thị hoặc ẩn tất cả các đánh giá
        let reviewsContainer = document.getElementById('reviewsContainer');
        let toggleBtn = document.getElementById('toggleReviewsBtn');

        // Mặc định ẩn các đánh giá
        reviewsContainer.style.display = 'none';

        toggleBtn.addEventListener('click', function() {
            if (reviewsContainer.style.display === 'none') {
                reviewsContainer.style.display = 'block'; // Hiển thị tất cả đánh giá
                toggleBtn.textContent = 'Ẩn tất cả đánh giá'; // Đổi văn bản nút thành "Ẩn tất cả đánh giá"
            } else {
                reviewsContainer.style.display = 'none'; // Ẩn tất cả đánh giá
                toggleBtn.textContent = 'Xem tất cả đánh giá'; // Đổi văn bản nút thành "Xem tất cả đánh giá"
            }
        });
    </script>
</body>

</html>