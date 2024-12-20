<?php
require("../../db.php");
session_start(); // Đảm bảo rằng người dùng đã đăng nhập

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: /php_btl/login/login.php"); // Chuyển hướng tới trang đăng nhập nếu người dùng chưa đăng nhập
    exit();
}

if (isset($_POST['submit_feedback'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Kiểm tra xem các trường có được điền đầy đủ hay không
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Lưu thông tin vào cơ sở dữ liệu
        $user_id = $_SESSION['user_id']; // Lấy ID người dùng từ session

        // Câu lệnh SQL để lưu góp ý vào cơ sở dữ liệu
        $sql = "INSERT INTO feedbacks (user_id, name, email, message, status) VALUES (:user_id, :name, :email, :message, 'pending')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':name' => $name,
            ':email' => $email,
            ':message' => $message,
        ]);
        $success_message = "Cảm ơn bạn đã gửi góp ý!";
    } else {
        $error_message = "Vui lòng điền đầy đủ thông tin!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Góp Ý</title>
    <link rel="stylesheet" href="../../css/feedback.css">
</head>

<body>
    <div class="container">
        <h1>Góp Ý</h1>

        <!-- Hiển thị thông báo thành công hoặc lỗi -->
        <?php if (isset($success_message)): ?>
            <p style="color: green;"><?php echo $success_message; ?></p>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <!-- Form để người dùng gửi góp ý -->
        <form method="POST" action="">
            <label for="name">Họ và tên:</label><br>
            <input type="text" name="name" id="name" required><br>

            <label for="email">Email:</label><br>
            <input type="email" name="email" id="email" required><br>

            <label for="message">Nội dung góp ý:</label><br>
            <textarea name="message" id="message" rows="5" required></textarea><br>

            <button type="submit" name="submit_feedback">Gửi Góp Ý</button>
        </form>

        <!-- Liên kết quay lại trang chủ -->
        <a href="../../index.php">Quay lại trang chủ</a>
    </div>
</body>

</html>