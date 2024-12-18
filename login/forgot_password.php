<?php
require '../db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];

    // Kiểm tra tài khoản có tồn tại hay không
    $stmt = $pdo->prepare("
        SELECT u.id, sq.question 
        FROM users u
        JOIN security_questions sq ON u.id = sq.user_id
        WHERE u.username = ?
    ");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Lưu thông tin vào session để sử dụng ở bước sau
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['security_question'] = $user['question'];
        $show_methods = true; // Hiển thị lựa chọn phương thức
    } else {
        $error_message = "Tài khoản không tồn tại.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu</title>
    <link rel="stylesheet" href="../css/forgot_password.css">
</head>

<body>
    <main>
        <h1>Quên mật khẩu</h1>

        <?php if (!isset($show_methods)): ?>
            <!-- Form nhập tên tài khoản -->
            <form method="POST" action="forgot_password.php">
                <label for="username">Tên tài khoản:</label>
                <input type="text" id="username" name="username" required>
                <button type="submit">Tiếp tục</button>
                <!-- <?php if (isset($error_message)): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php endif; ?> -->
                <a href="./login.php">Quay về Đăng nhập</a>
            </form>
        <?php else: ?>
            <!-- Hiển thị lựa chọn phương thức -->
            <div>
                <p>Chọn một phương thức để khôi phục mật khẩu:</p>
                <ul>
                    <li>
                        <form method="POST" action="answer_security_question.php">
                            <button type="submit">Câu trả lời bảo mật</button>
                        </form>
                    </li>
                    <li>
                        <button disabled>OTP qua số điện thoại (Chưa khả dụng)</button>
                    </li>
                    <li>
                        <button disabled>Email (Chưa khả dụng)</button>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </main>
</body>

</html>