<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'db.php';

// Kiểm tra nếu người dùng đã đăng nhập
$isLoggedIn = isset($_SESSION['username']);
$isAdmin = ($isLoggedIn && $_SESSION['role'] === 'admin');

// Tính số lượng sản phẩm trong giỏ hàng
$cart_count = 0;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT SUM(quantity) AS total_quantity FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $cart_count = $result['total_quantity'] ?? 0;
}

// Lấy danh sách danh mục và loại sản phẩm
$categories = $pdo->query("
    SELECT c.id AS category_id, c.name AS category_name, sc.id AS subcategory_id, sc.name AS subcategory_name
    FROM categories c
    LEFT JOIN subcategories sc ON c.id = sc.category_id
    ORDER BY c.name, sc.name
")->fetchAll(PDO::FETCH_ASSOC);

// Tổ chức danh mục và loại sản phẩm thành mảng
$menu = [];
foreach ($categories as $row) {
    $menu[$row['category_name']][] = [
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
    <title><?php echo $pageTitle ?? 'Trang Web'; ?></title>
    <link rel="stylesheet" href="./css/header.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <header class="header">
        <div class="header-top">
            <!-- Logo -->
            <div class="logo">
                <a href="/php_btl/index.php">
                    <img src="/php_btl/logo.png" alt="Logo">
                </a>
            </div>

            <div class="dropdown"><a href="/php_btl/business_strategy.php">Giới thiệu</a></div>
            <div class="dropdown"><a href="/php_btl/Pages/track_order/track_order.php">Tra cứu đơn hàng</a></div>

            <!-- Thanh tìm kiếm ở giữa -->
            <form class="search-bar" action="search.php" method="GET">
                <input type="text" name="query" placeholder="Bạn cần tìm gì?" required>
                <button type="search"><i class="fas fa-search"></i></button>
            </form>

            <div class="dropdown"><a href="/php_btl/Pages/feedback/feedback.php">Góp ý</a></div>
            <div class="dropdown"><a href="/php_btl/Pages/News/new_list.php">Tin tức</a></div>

            <!-- Icon bên phải -->
            <div class="header-icons">
                <?php if ($isLoggedIn): ?>
                    <div class="user-welcome">
                        <?php echo htmlspecialchars($_SESSION['role'] === 'admin' ? 'AD-' : '') . htmlspecialchars($_SESSION['username']); ?>!
                        <div class="dropdown-menu">
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <a href="/php_btl/admin/dashboard.php">Quản trị</a>
                            <?php else: ?>
                                <a href="/php_btl/profile.php">Hồ sơ</a>
                                <a href="/php_btl/Pages/orders/user_orders.php">Đơn hàng</a>
                                <a href="/php_btl/Pages/orders/purchase_history.php">Lịch sử mua hàng</a>
                                <a href="/php_btl/Pages/History_review/history_reviews.php">Lịch sử đánh giá</a>
                                <a href="/php_btl/Pages/feedback/feedback_history.php">Lịch sử góp ý</a>
                            <?php endif; ?>
                            <a href="/php_btl/change_password.php">Đổi mật khẩu</a>
                            <a href="/php_btl/login/logout.php">Đăng xuất</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="user-icon">
                        <i class="fas fa-user"></i>
                        <div class="dropdown-menu">
                            <a href="/php_btl/login/login.php">Đăng nhập</a>
                            <a href="/php_btl/login/register.php">Đăng ký</a>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="icon cart-icon">
                    <a href="/php_btl/cart/cart.php">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count"><?php echo $cart_count; ?></span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Thanh menu -->
        <nav class="header-nav">
            <ul>
                <div><a href="/php_btl/index.php">Trang chủ</a></div>

                <?php foreach ($menu as $category_name => $subcategories): ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle"><?php echo htmlspecialchars($category_name); ?></a>
                        <ul class="dropdown-menu">
                            <?php foreach ($subcategories as $subcategory): ?>
                                <?php if (!empty($subcategory['subcategory_id'])): ?>
                                    <li>
                                        <a href="/php_btl/category.php?category=<?php echo urlencode($category_name); ?>&subcategory_id=<?php echo $subcategory['subcategory_id']; ?>">
                                            <?php echo htmlspecialchars($subcategory['subcategory_name']); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </header>
</body>

</html>
