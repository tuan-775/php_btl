<?php
require '../db.php';
session_start();

// Kiểm tra session
if (!isset($_SESSION['user_id']) || !isset($_SESSION['security_question'])) {
    header("Location: forgot_password.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$security_question = $_SESSION['security_question'];
$error_message = ""; // Khởi tạo thông báo lỗi
$correct_answer = false; // Biến kiểm tra câu trả lời đúng

// Xử lý khi form được gửi bằng POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['security_answer']) && !empty(trim($_POST['security_answer']))) {
        $security_answer = trim($_POST['security_answer']);

        // Lấy câu trả lời từ CSDL
        $stmt = $pdo->prepare("SELECT answer FROM security_questions WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Kiểm tra câu trả lời bảo mật
        if ($user && password_verify($security_answer, $user['answer'])) {
            $correct_answer = true; // Đánh dấu câu trả lời đúng
        } else {
            $error_message = "Câu trả lời bảo mật không chính xác.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trả lời câu hỏi bảo mật</title>
    <script>
        // Hiển thị hộp thoại xác nhận khi trả lời đúng
        function confirmResetPassword() {
            const confirmAction = confirm("Bạn có chắc chắn muốn đổi mật khẩu không?");
            if (confirmAction) {
                window.location.href = "reset_password.php"; // Chuyển trang nếu người dùng xác nhận
            }
        }
    </script>
</head>
<body>
    <h1>Trả lời câu hỏi bảo mật</h1>
    <form method="POST" action="answer_security_question.php">
        <p><strong>Câu hỏi bảo mật:</strong> <?php echo htmlspecialchars($security_question); ?></p>
        <label for="security_answer">Câu trả lời:</label>
        <input type="text" id="security_answer" name="security_answer" required>
        <button type="submit">Xác nhận</button>
        <?php if (!empty($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </form>

    <!-- Xử lý khi câu trả lời đúng -->
    <?php if ($correct_answer): ?>
        <script>
            confirmResetPassword();
        </script>
    <?php endif; ?>
</body>
</html>
