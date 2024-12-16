<?php
require '../db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: forgot_password.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error_message = "Mật khẩu xác nhận không khớp.";
    } else {
        // Mã hóa mật khẩu mới và cập nhật vào CSDL
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashed_password, $user_id]);

        // Xóa session sau khi đặt lại mật khẩu thành công
        session_destroy();

        echo "<p>Mật khẩu đã được đặt lại thành công. <a href='login.php'>Đăng nhập ngay</a></p>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt lại mật khẩu</title>
</head>
<body>
    <h1>Đặt lại mật khẩu</h1>
    <form method="POST" action="reset_password.php">
        <label for="new_password">Mật khẩu mới:</label>
        <input type="password" id="new_password" name="new_password" required>
        <label for="confirm_password">Xác nhận mật khẩu:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <button type="submit">Đặt lại mật khẩu</button>
        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </form>
</body>
</html>
