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
        echo "
            <div id='error-popup' class='popup'>
                <div class='popup-content'>
                    <span class='popup-close' onclick='closePopup()'>&times;</span>
                    <h2>Đăng Nhập Thất Bại!</h2>
                    <p>Tên đăng nhập hoặc mật khẩu không chính xác. Vui lòng thử lại.</p>
                    <button class='close-btn' onclick='closePopup()'>Đã Hiểu</button>
                </div>
            </div>
        ";
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

    <div class="main">

        <form action="" method="POST" class="form" id="register-form">
            <h3 class="heading">Đăng nhập</h3>

            <div class="spacer"></div>

            <div class="form-group">
                <label for="username" class="form-label">Tên đăng nhập</label>
                <input id="username" name="username" rules="required|email" type="text"
                    class="form-control">
                <span class="form-message"></span>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Mật khẩu</label>
                <input id="password" name="password" rules="required|min:6" type="password" placeholder="Nhập mật khẩu"
                    class="form-control">
                <span class="form-message"></span>
            </div>

            <button class="form-submit">Đăng nhập</button>

            <div class="btn-backhome">
                <a href="../index.php">Quay lại trang chủ</a>
                <a href="forgot_password.php">Quên mật khẩu</a>
            </div>
        </form>

    </div>
    <script src="./validate.js"></script>
    <script>
        var form = new Validator('#register-form');

        form.onSubmit = function(formData) {
            console.log(formData);
        }

        function closePopup() {
            document.getElementById('error-popup').style.display = 'none';
        }
    </script>
</body>

</html>