<?php

require 'db.php';

// Kiểm tra nếu người dùng đã đăng nhập
$isLoggedIn = isset($_SESSION['username']);
$isAdmin = ($isLoggedIn && $_SESSION['role'] === 'admin');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$cart_count = 0;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT SUM(quantity) AS total_quantity FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $cart_count = $result['total_quantity'] ?? 0;
}

$stmt_be_gai = $pdo->prepare("SELECT DISTINCT category_name FROM products WHERE category = ?");
$stmt_be_gai->execute(['Bé gái']);
$subcategories_be_gai = $stmt_be_gai->fetchAll(PDO::FETCH_ASSOC);

// Lấy danh mục con cho Bé trai
$stmt_be_trai = $pdo->prepare("SELECT DISTINCT category_name FROM products WHERE category = ?");
$stmt_be_trai->execute(['Bé trai']);
$subcategories_be_trai = $stmt_be_trai->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Trang Web'; ?></title>
    <!-- <link rel="stylesheet" href="css/style.css">  -->
    <link rel="stylesheet" href="./css/header.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playpen+Sans:wght@100..800&family=Sofadi+One&display=swap" rel="stylesheet">
</head>

<body>
    <header class="header">
        <div class="header-top">
            <!-- Logo -->
            <div class="logo">
                <a href="./index.php">
                    <img src="./logo.png" />
                </a>
            </div>

            <!-- Thanh tìm kiếm ở giữa -->
            <form class="search-bar" action="search.php" method="GET">
                <input type="text" name="query" placeholder="Bạn cần tìm gì?" required>
                <button type="submit"><i class="fas fa-search"></i></button>
                </input>
            </form>

            <!-- Icon bên phải -->
            <div class="header-icons">
                <?php if (isset($_SESSION['username']) && isset($_SESSION['role'])): ?>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <!-- Menu cho Admin -->
                        <div class="user-welcome">
                            AD-<?php echo htmlspecialchars($_SESSION['username']); ?>!
                            <div class="dropdown-menu">
                                <a href="./admin/dashboard.php">Quản trị</a>
                                <a href="./change_password.php">Đổi mật khẩu</a>
                                <a href="./login/logout.php">Đăng xuất</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Menu cho Người dùng -->
                        <div class="user-welcome">
                            <?php echo htmlspecialchars($_SESSION['username']); ?>!
                            <div class="dropdown-menu">
                                <a href="./profile.php">Hồ sơ</a>
                                <a href="./purchase_history.php">Lịch sử mua hàng</a>
                                <a href="./change_password.php">Đổi mật khẩu</a>
                                <a href="./login/logout.php">Đăng xuất</a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <!-- Menu cho khách chưa đăng nhập -->
                    <div class="user-icon">
                        <i class="fas fa-user"></i>
                        <div class="dropdown-menu">
                            <a href="./login/login.php">Đăng nhập</a>
                            <a href="./login/register.php">Đăng ký</a>
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
                <div class="business-strategy">
                    <a href="/php_btl/business_strategy.php">Giới thiệu</a>
                </div>
                <li class="dropdown">
                    <a href="/php_btl/category.php?category=Bé gái" class="dropdown-toggle">Bé gái</a>
                    <ul class="dropdown-menu">
                        <li><a href="/php_btl/category.php?category=Bé gái&&category_name=Đầm váy">Đầm váy</a></li>
                        <li><a href="/php_btl/category.php?category=Bé gái&category_name=Áo">Áo</a></li>
                        <li><a href="/php_btl/category.php?category=Bé gái&category_name=Đồ bộ">Đồ bộ</a></li>
                        <li><a href="/php_btl/category.php?category=Bé gái&category_name=Phụ kiện">Phụ kiện</a></li>
                    </ul>
                </li>
                <!-- Bé trai -->
                <li class="dropdown">
                    <a href="/php_btl/category.php?category=Bé trai" class="dropdown-toggle">Bé trai</a>
                    <ul class="dropdown-menu">
                        <li><a href="/php_btl/category.php?category=Bé trai&category_name=Áo">Áo</a></li>
                        <li><a href="/php_btl/category.php?category=Bé trai&category_name=Quần">Quần</a></li>
                        <li><a href="/php_btl/category.php?category=Bé trai&category_name=Đồ bộ">Đồ bộ</a></li>
                        <li><a href="/php_btl/category.php?category=Bé trai&category_name=Phụ kiện">Phụ kiện</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">Bộ sưu tập</a>
                    <ul class="dropdown-menu">
                        <li><a href="/php_btl/collection.php?collection=BST Thu Đông">BST Thu Đông</a></li>
                        <li><a href="/php_btl/collection.php?collection=BST Đồ Bộ Mặc Nhà">BST Đồ Bộ Mặc Nhà</a></li>
                        <li><a href="/php_btl/collection.php?collection=BST Đồ Đi Chơi Noel">BST Đồ Đi Chơi Noel</a></li>
                        <li><a href="/php_btl/collection.php?collection=BST Disney - Friends">BST Disney - Friends</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">New Arrival</a>
                    <ul class="dropdown-menu">
                        <li><a href="/php_btl/new_arrival.php?category=Bé gái">New Arrival Bé gái</a></li>
                        <li><a href="/php_btl/new_arrival.php?category=Bé trai">New Arrival Bé trai</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">⚡ SALE ⚡</a>
                    <ul class="dropdown-menu">
                        <li><a href="/php_btl/sale.php?sale_range=10-25">Sale 10%-25%</a></li>
                        <li><a href="/php_btl/sale.php?sale_range=25-50">Sale 25%-50%</a></li>
                        <li><a href="/php_btl/sale.php?category=Bé gái">Sale Bé gái</a></li>
                        <li><a href="/php_btl/sale.php?category=Bé trai">Sale Bé trai</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
</body>