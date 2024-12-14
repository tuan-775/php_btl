<?php
require '../db.php';
session_start();

// Kiểm tra quyền admin
if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập.";
    exit;
}

// Lấy danh sách người dùng với thời gian cập nhật mới nhất
$stmt = $pdo->prepare(
    "SELECT 
        users.id AS user_id,
        users.username,
        users.email,
        users.created_at,
        user_profiles.gender,
        user_profiles.birthdate,
        user_profiles.phone,
        user_profiles.address,
        (
            SELECT MAX(GREATEST(users.created_at, user_profiles.updated_at))
            FROM user_profiles 
            WHERE user_profiles.user_id = users.id
        ) AS updated_at
     FROM 
        users
     LEFT JOIN 
        user_profiles 
     ON 
        users.id = user_profiles.user_id
     WHERE 
        users.role = 'user'
     GROUP BY 
        users.id"
);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
</head>
<body>
    <h1>Quản lý người dùng</h1>
    <a href="dashboard.php">Quay lại trang quản lý</a>
    <a href="add_user.php">Thêm người dùng</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Tên đăng nhập</th>
            <th>Email</th>
            <th>Giới tính</th>
            <th>Ngày sinh</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Thời gian tạo</th>
            <th>Thời gian cập nhật</th>
            <th>Hành động</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['gender']); ?></td>
                <td><?php echo htmlspecialchars($user['birthdate']); ?></td>
                <td><?php echo htmlspecialchars($user['phone']); ?></td>
                <td><?php echo htmlspecialchars($user['address']); ?></td>
                <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                <td><?php echo htmlspecialchars($user['updated_at']); ?></td>
                <td>
                    <a href="edit_user.php?id=<?php echo $user['user_id']; ?>" class="btn-edit">Sửa</a>
                    <a href="delete_user.php?delete_user_id=<?php echo $user['user_id']; ?>" class="btn-delete" 
                       onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
