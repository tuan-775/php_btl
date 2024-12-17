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
$stmt = $pdo->prepare(
    "SELECT users.fullname, users.username, users.email, user_profiles.gender, 
            user_profiles.birthdate, user_profiles.phone, user_profiles.address 
     FROM users 
     LEFT JOIN user_profiles ON users.id = user_profiles.user_id 
     WHERE users.id = ?"
);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Không tìm thấy thông tin người dùng.";
    exit;
}

// Xử lý cập nhật thông tin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy thông tin từ form
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Kiểm tra dữ liệu hợp lệ
    if (empty($fullname) || empty($username) || empty($email)) {
        $error = "Vui lòng điền đầy đủ họ tên, tên đăng nhập và email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Địa chỉ email không hợp lệ.";
    } elseif (!empty($password) && $password !== $confirm_password) {
        $error = "Mật khẩu nhập lại không khớp.";
    } else {
        try {
            $pdo->beginTransaction();

            // Cập nhật bảng users
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare(
                    "UPDATE users SET fullname = ?, username = ?, email = ?, password = ? WHERE id = ?"
                );
                $stmt->execute([$fullname, $username, $email, $hashedPassword, $user_id]);
            } else {
                $stmt = $pdo->prepare(
                    "UPDATE users SET fullname = ?, username = ?, email = ? WHERE id = ?"
                );
                $stmt->execute([$fullname, $username, $email, $user_id]);
            }

            // Cập nhật bảng user_profiles (chỉnh sửa giới tính, ngày sinh, điện thoại và địa chỉ)
            $stmt = $pdo->prepare(
                "INSERT INTO user_profiles (user_id, gender, birthdate, phone, address) 
                 VALUES (?, ?, ?, ?, ?) 
                 ON DUPLICATE KEY UPDATE 
                 gender = VALUES(gender), 
                 birthdate = VALUES(birthdate), 
                 phone = VALUES(phone), 
                 address = VALUES(address)"
            );
            $stmt->execute([$user_id, $gender, $birthdate, $phone, $address]);

            $pdo->commit();

            // Cập nhật thông tin session nếu cần (ví dụ: nếu bạn lưu fullname trong session)
            $_SESSION['username'] = $username;
            // Nếu bạn lưu fullname trong session, hãy cập nhật nó ở đây
            // $_SESSION['fullname'] = $fullname;

            // Chuyển hướng về trang hồ sơ
            header("Location: profile.php");
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            // Ghi log lỗi để dễ dàng theo dõi
            // error_log($e->getMessage());
            $error = "Đã xảy ra lỗi khi cập nhật thông tin.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa hồ sơ</title>
    <link rel="stylesheet" href="./css/edit_profile.css">
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
                <label for="fullname">Họ và tên:</label>
                <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>

                <label for="username">Tên người dùng:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <label for="gender">Giới tính:</label>
                <select id="gender" name="gender">
                    <option value="" <?php echo empty($user['gender']) ? 'selected' : ''; ?>>Chưa chọn</option>
                    <option value="Nam" <?php echo $user['gender'] === 'Nam' ? 'selected' : ''; ?>>Nam</option>
                    <option value="Nữ" <?php echo $user['gender'] === 'Nữ' ? 'selected' : ''; ?>>Nữ</option>
                    <option value="Khác" <?php echo $user['gender'] === 'Khác' ? 'selected' : ''; ?>>Khác</option>
                </select>

                <label for="birthdate">Ngày sinh:</label>
                <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($user['birthdate']); ?>">

                <label for="phone">Số điện thoại:</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">

                <label for="address">Địa chỉ:</label>
                <textarea id="address" name="address"><?php echo htmlspecialchars($user['address']); ?></textarea>

                <div class="button-container">
                    <a href="profile.php" class="back-btn">Quay lại hồ sơ</a>
                    <button type="submit" id='save-submit' class="btn-submit">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>