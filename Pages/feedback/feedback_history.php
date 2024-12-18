<?php
require("../../db.php");
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Lấy ID người dùng từ session
$user_id = $_SESSION['user_id'];

// Truy vấn các góp ý của người dùng từ cơ sở dữ liệu
$sql = "SELECT * FROM feedbacks WHERE user_id = :user_id ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([':user_id' => $user_id]);
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Sử Góp Ý</title>
    <link rel="stylesheet" href="../../css/feedback_history.css">
</head>
<body>
    <div class="container">
        <h1>Lịch Sử Góp Ý</h1>

        <?php if (count($feedbacks) > 0): ?>
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Nội Dung</th>
                        <th>Ngày Gửi</th>
                        <th>Trạng Thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($feedbacks as $feedback): ?>
                        <tr>
                            <td><?php echo $feedback['id']; ?></td>
                            <td><?php echo htmlspecialchars($feedback['name']); ?></td>
                            <td><?php echo htmlspecialchars($feedback['email']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($feedback['message'])); ?></td>
                            <td><?php echo $feedback['created_at']; ?></td>
                            <td>
                                <?php if ($feedback['status'] == 'pending'): ?>
                                    <span style="color: orange;">Chưa xử lý</span>
                                <?php elseif ($feedback['status'] == 'resolved'): ?>
                                    <span style="color: green;">Đã xử lý</span>
                                <?php else: ?>
                                    <span style="color: red;">Đã xóa</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Hiện tại bạn chưa có góp ý nào.</p>
        <?php endif; ?>

        <a href="../../index.php">Quay lại trang chủ</a>
    </div>
</body>
</html>
