<?php

require 'db.php';

// Kiểm tra nếu người dùng đã đăng nhập
$isLoggedIn = isset($_SESSION['username']);
$isAdmin = ($isLoggedIn && $_SESSION['role'] === 'admin');
if (isset($_GET['message']) && $_GET['message'] === 'login_required') {
    echo "<p style='color: red;'>Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!</p>";
}
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
    <link rel="stylesheet" href="css/style.css"> <!-- Liên kết tới file CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="header-top">
            <!-- Logo -->
            <div class="logo">
                <a href="/BTL_PHP/index.php">
                    <img src="/BTL_PHP/logo.png" alt="Rabity Logo">
                </a>
            </div>

            <!-- Thanh tìm kiếm ở giữa -->
            <form class="search-bar" action="search.php" method="GET">
                <input type="text" name="query" placeholder="Bạn cần tìm gì?" required>
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>

            <!-- Icon bên phải -->
            <div class="header-icons">
            <?php if (isset($_SESSION['username']) && isset($_SESSION['role'])): ?>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <!-- Menu cho Admin -->
                        <div class="user-welcome">
                            Quản trị, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                            <div class="dropdown-menu">
                                <a href="/BTL_PHP/admin/dashboard.php">Quản trị</a>
                                <a href="/BTL_PHP/login/logout.php">Đăng xuất</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Menu cho Người dùng -->
                        <div class="user-welcome">
                            Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                            <div class="dropdown-menu">
                                <a href="/BTL_PHP/profile.php">Hồ sơ</a>
                                <a href="/BTL_PHP/login/logout.php">Đăng xuất</a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <!-- Menu cho khách chưa đăng nhập -->
                    <div class="user-icon">
                        <i class="fas fa-user"></i>
                        <div class="dropdown-menu">
                            <a href="/BTL_PHP/login/login.php">Đăng nhập</a>
                            <a href="/BTL_PHP/login/register.php">Đăng ký</a>
                        </div>
                    </div>
            <?php endif; ?>
            <div class="icon cart-icon">
                <a href="/BTL_PHP/cart/cart.php">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count"><?php echo $cart_count; ?></span>
                </a>
            </div>
            </div>
        </div>

        <!-- Thanh menu -->
        <nav class="header-nav">
            <ul>
                <li class="dropdown">
                    <a href="category.php?category=Bé gái" class="dropdown-toggle">Bé gái</a>
                    <ul class="dropdown-menu">
                        <li><a href="category.php?category=Bé gái&&category_name=Đầm váy">Đầm váy</a></li>
                        <li><a href="category.php?category=Bé gái&category_name=Áo">Áo</a></li>
                        <li><a href="category.php?category=Bé gái&category_name=Đồ bộ">Đồ bộ</a></li>
                        <li><a href="category.php?category=Bé gái&category_name=Phụ kiện">Phụ kiện</a></li>
                    </ul>
                </li>
                <!-- Bé trai -->
                <li class="dropdown">
                    <a href="category.php?category=Bé trai" class="dropdown-toggle">Bé trai</a>
                    <ul class="dropdown-menu">
                        <li><a href="category.php?category=Bé trai&category_name=Áo">Áo</a></li>
                        <li><a href="category.php?category=Bé trai&category_name=Quần">Quần</a></li>
                        <li><a href="category.php?category=Bé trai&category_name=Đồ bộ">Đồ bộ</a></li>
                        <li><a href="category.php?category=Bé trai&category_name=Phụ kiện">Phụ kiện</a></li>
                    </ul>
                </li>
                <li><a href="#">Bộ sưu tập</a></li>
                <li><a href="#">New Arrival</a></li>
                <li><a href="#">⚡ SALE ⚡</a></li>
                <li><a href="#">Cửa hàng</a></li>
                <li><a href="#">Tin tức</a></li>
            </ul>
        </nav>
    </header>
