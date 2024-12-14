<?php
session_start();
require './db.php';

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Kiểm tra khi form được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Lấy thông tin người dùng từ cơ sở dữ liệu
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    // Kiểm tra mật khẩu cũ
    if ($user && password_verify($old_password, $user['password'])) {
        // Kiểm tra mật khẩu mới và xác nhận mật khẩu
        if ($new_password === $confirm_password && strlen($new_password) >= 6) {
            // Mã hóa mật khẩu mới
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            // Cập nhật mật khẩu mới vào cơ sở dữ liệu
            $update_stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update_stmt->execute([$hashed_password, $user_id]);

            // Thông báo thành công
            $message = "Mật khẩu đã được thay đổi thành công!";
        } else {
            $message = "Mật khẩu mới và xác nhận mật khẩu không khớp hoặc quá ngắn!";
        }
    } else {
        $message = "Mật khẩu cũ không đúng!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi mật khẩu</title>
    <link rel="stylesheet" href="./css/change_password.css">
</head>

<body>

    <div class="main">
        <form action="" method="POST" class="form">
            <h3 class="heading">Đổi mật khẩu</h3>

            <?php if (isset($message)): ?>
                <div class="notification-message">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="old_password" class="form-label">Mật khẩu cũ</label>
                <input id="old_password" name="old_password" type="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="new_password" class="form-label">Mật khẩu mới</label>
                <input id="new_password" name="new_password" type="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
                <input id="confirm_password" name="confirm_password" type="password" class="form-control" required>
            </div>

            <button type="submit" class="form-submit">Đổi mật khẩu</button>

            <div class="btn-backhome">
                <a href="./index.php">Quay lại trang chủ</a>
            </div>
        </form>
    </div>

</body>

</html>