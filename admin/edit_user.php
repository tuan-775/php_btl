<?php
require '../db.php';
session_start();

// Kiểm tra quyền admin
if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập.";
    exit;
}

// Lấy thông tin người dùng cần sửa
$user_id = $_GET['id'] ?? null;
if (!$user_id) {
    echo "ID người dùng không hợp lệ.";
    exit;
}

// Truy vấn thông tin từ bảng `users` và `user_profiles`
$stmt = $pdo->prepare(
    "SELECT users.id AS user_id, users.username, users.email, 
            user_profiles.gender, user_profiles.birthdate, 
            user_profiles.phone, user_profiles.address 
     FROM users
     LEFT JOIN user_profiles ON users.id = user_profiles.user_id 
     WHERE users.id = ?"
);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Người dùng không tồn tại.";
    exit;
}

// Xử lý cập nhật thông tin người dùng
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    try {
        // Bắt đầu giao dịch
        $pdo->beginTransaction();

        // Cập nhật thông tin trong bảng `users`
        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $stmt->execute([$username, $email, $user_id]);

        // Cập nhật thông tin trong bảng `user_profiles` và cập nhật `updated_at`
        $stmt = $pdo->prepare(
            "UPDATE user_profiles 
             SET gender = ?, birthdate = ?, phone = ?, address = ?, updated_at = NOW() 
             WHERE user_id = ?"
        );
        $stmt->execute([$gender, $birthdate, $phone, $address, $user_id]);

        // Hoàn thành giao dịch
        $pdo->commit();

        header("Location: manage_users.php?message=edit_success");
        exit;
    } catch (Exception $e) {
        // Hủy giao dịch nếu có lỗi
        $pdo->rollBack();
        echo "Lỗi: " . $e->getMessage();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Người Dùng</title>
    <link rel="stylesheet" href="./css/edit_user.css">
</head>
<body>
    <h1>Chỉnh Sửa Người Dùng</h1>
    <form method="POST">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>
        
        <label for="gender">Giới tính:</label>
        <select id="gender" name="gender">
            <option value="Nam" <?php echo $user['gender'] == 'Nam' ? 'selected' : ''; ?>>Nam</option>
            <option value="Nữ" <?php echo $user['gender'] == 'Nữ' ? 'selected' : ''; ?>>Nữ</option>
        </select><br>
        
        <label for="birthdate">Ngày sinh:</label>
        <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($user['birthdate']); ?>"><br>
        
        <label for="phone">Số điện thoại:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"><br>
        
        <label for="address">Địa chỉ:</label>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>"><br>
        
        <button type="submit">Cập Nhật</button>
        <a href="./manage_users.php">Quản lí người dùng</a>
    </form>
</body>
</html>
