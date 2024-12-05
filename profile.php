<?php
session_start();
require 'db.php';

// Kiểm tra người dùng đã đăng nhập hay chưa
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ sơ người dùng</title>
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="profile-container">
            <h1>Hồ sơ của bạn</h1>
            <div class="profile-info">
                <p><strong>Tên người dùng:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Ngày đăng ký:</strong> <?php echo htmlspecialchars($user['created_at']); ?></p>
            </div>
            <a href="edit_profile.php" class="edit-btn">Chỉnh sửa hồ sơ</a>
            <a href="login/logout.php" class="logout-btn">Đăng xuất</a>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>