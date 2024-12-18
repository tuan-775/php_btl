<?php
require("../../db.php");
session_start();

// Kiểm tra quyền admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo "Bạn không có quyền truy cập trang này! <a href='../login.php'>Đăng nhập</a>";
    exit();
}

// Cập nhật trạng thái góp ý
if (isset($_GET['status']) && isset($_GET['id'])) {
    $status = $_GET['status'];
    $id = $_GET['id'];
    
    if ($status == 'resolved' || $status == 'pending') {
        $sql = "UPDATE feedbacks SET status = :status WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':status' => $status, ':id' => $id]);
    }
    
    // Chuyển hướng lại trang quản lý
    header("Location: manage_feedback.php");
    exit();
}

// Xóa góp ý
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "UPDATE feedbacks SET status = 'deleted' WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    // Chuyển hướng lại trang quản lý
    header("Location: manage_feedback.php");
    exit();
}

// Truy vấn danh sách góp ý
$sql = "SELECT * FROM feedbacks WHERE status != 'deleted' ORDER BY created_at DESC";
$stmt = $pdo->query($sql);
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Góp Ý</title>
    <link rel="stylesheet" href="../css/manage_feedback.css">
</head>
<body>
    <div class="container">
        <h1>Quản Lý Góp Ý</h1>
        <a href="../dashboard.php" class="btn btn-primary">Quay lại trang quản trị</a>
        <!-- Danh sách góp ý -->
        <h3>Danh Sách Góp Ý</h3>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Nội Dung</th>
                    <th>Ngày Gửi</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
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
                        <td>
                            <?php if ($feedback['status'] == 'pending'): ?>
                                <a href="?status=resolved&id=<?php echo $feedback['id']; ?>">Đánh dấu đã xử lý</a> |
                            <?php elseif ($feedback['status'] == 'resolved'): ?>
                                <a href="?status=pending&id=<?php echo $feedback['id']; ?>">Đánh dấu chưa xử lý</a> |
                            <?php endif; ?>
                            <a href="?delete_id=<?php echo $feedback['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
