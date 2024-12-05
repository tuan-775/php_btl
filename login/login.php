<?php
require '../db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra tài khoản
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Lưu thông tin vào session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Chuyển hướng về trang chủ
        header("Location: ../index.php");
        exit;
    } else {
        echo "Sai tên đăng nhập hoặc mật khẩu!";
    }
}

// Hiển thị thông báo nếu được chuyển đến từ `add_to_cart.php`
$message = isset($_GET['message']) && $_GET['message'] === 'login_required' ? "Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!" : "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="../css/login.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> <!-- Font Awesome -->
</head>

<body>
    <?php if ($message): ?>
        <div class="notification-message">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <h2>Đăng nhập</h2>
        <label for="username">Tên đăng nhập:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Mật khẩu:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Đăng nhập</button>
        <a href="../index.php">Quay lại trang chủ</a>
    </form>
</body>

</html>