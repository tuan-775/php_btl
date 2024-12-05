<?php
session_start();
require 'db.php';

// Kiểm tra người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Lấy thông tin người dùng từ cơ sở dữ liệu
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Không tìm thấy thông tin người dùng.";
    exit;
}

// Xử lý cập nhật thông tin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($email)) {
        $error = "Vui lòng điền đầy đủ thông tin.";
    } elseif (!empty($password) && $password !== $confirm_password) {
        $error = "Mật khẩu nhập lại không khớp.";
    } else {
        if (!empty($password)) {
            // Mã hóa mật khẩu nếu người dùng thay đổi
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("
                UPDATE users 
                SET username = ?, email = ?, password = ? 
                WHERE id = ?
            ");
            $stmt->execute([$username, $email, $hashedPassword, $user_id]);
        } else {
            // Không thay đổi mật khẩu
            $stmt = $pdo->prepare("
                UPDATE users 
                SET username = ?, email = ? 
                WHERE id = ?
            ");
            $stmt->execute([$username, $email, $user_id]);
        }

        // Cập nhật thông tin session
        $_SESSION['username'] = $username;

        // Chuyển hướng về trang hồ sơ
        header("Location: profile.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa hồ sơ</title>
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="edit-profile-container">
            <h1>Chỉnh sửa hồ sơ</h1>
            <?php if (!empty($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST">
                <label for="username">Tên người dùng:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <label for="password">Mật khẩu mới (nếu muốn thay đổi):</label>
                <input type="password" id="password" name="password" placeholder="Để trống nếu không muốn thay đổi">

                <label for="confirm_password">Nhập lại mật khẩu:</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu mới">

                <div class="button-container">
                    <a href="profile.php" class="back-btn">Quay lại hồ sơ</a>
                    <button type="submit" class="btn-submit">Lưu thay đổi</button>
                </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>