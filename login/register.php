<?php
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra mật khẩu khớp nhau
    if ($password !== $confirm_password) {
        echo "Mật khẩu nhập lại không khớp!";
        exit;
    }

    // Mã hóa mật khẩu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Mặc định vai trò là người dùng
    $role = 'user';

    // Thêm tài khoản vào cơ sở dữ liệu
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    try {
        $stmt->execute([$username, $email, $hashed_password, $role]);
        echo "Đăng ký thành công! <a href='login.php'>Đăng nhập</a>";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "Tên đăng nhập hoặc email đã tồn tại!";
        } else {
            echo "Lỗi: " . $e->getMessage();
        }
    }
}
?>

<h2>Đăng ký tài khoản</h2>
<form method="post">
    <label for="username">Tên đăng nhập:</label><br>
    <input type="text" id="username" name="username" required><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Mật khẩu:</label><br>
    <input type="password" id="password" name="password" required><br>

    <label for="confirm_password">Nhập lại mật khẩu:</label><br>
    <input type="password" id="confirm_password" name="confirm_password" required><br><br>

    <button type="submit">Đăng ký</button>
</form>
