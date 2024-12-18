<?php
require '../db.php';
session_start();

// Kiểm tra quyền admin
if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Mã hóa mật khẩu
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $role = 'user'; // Mặc định thêm người dùng với vai trò "user"

    try {
        // Bắt đầu giao dịch
        $pdo->beginTransaction();

        // Thêm thông tin vào bảng `users`
        $stmt = $pdo->prepare("INSERT INTO users (fullname, username, email, password, role, created_at) 
                               VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$fullname, $username, $email, $password, $role]);

        // Lấy `user_id` vừa được thêm vào
        $user_id = $pdo->lastInsertId();

        // Thêm thông tin chi tiết vào bảng `user_profiles`
        $stmt = $pdo->prepare(
            "INSERT INTO user_profiles (user_id, gender, birthdate, phone, address, created_at, updated_at) 
             VALUES (?, ?, ?, ?, ?, NOW(), NOW())"
        );
        $stmt->execute([$user_id, $gender, $birthdate, $phone, $address]);

        // Hoàn thành giao dịch
        $pdo->commit();

        header("Location: manage_users.php?message=add_success");
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
    <title>Thêm Người Dùng</title>
    <link rel="stylesheet" href="./css/add_user.css">
</head>

<body>
    <h1>Thêm Người Dùng</h1>
    <form method="POST">
        <label for="fullname">Họ và tên</label>
        <input type="text" id="fullname" name="fullname" required><br>

        <label for="username">Tên đăng nhập:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="gender">Giới tính:</label>
        <select id="gender" name="gender" required>
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
        </select><br>

        <label for="birthdate">Ngày sinh:</label>
        <input type="date" id="birthdate" name="birthdate"><br>

        <label for="phone">Số điện thoại:</label>
        <input type="tel" id="phone" name="phone"><br>

        <label for="address">Địa chỉ:</label>
        <input type="text" id="address" name="address"><br>

        <button type="submit">Thêm Người Dùng</button>
        <a href="./manage_users.php">Quản lý người dùng</a>
    </form>
</body>

</html>