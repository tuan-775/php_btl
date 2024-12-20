<?php
require("../../db.php");
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo "Bạn không có quyền truy cập trang này! <a href='../login.php'>Đăng nhập</a>";
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: admin_manage_news.php");
    exit();
}

$id = $_GET['id'];

if (isset($_POST['update_news'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $image = '';

    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../../uploads/news/";
        $image = basename($_FILES['image']['name']);
        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        $sql = "UPDATE news SET image = :image WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':image' => $image, ':id' => $id]);
    }

    if (!empty($title) && !empty($content)) {
        $sql = "UPDATE news SET title = :title, content = :content, category = :category WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':category' => $category,
            ':id' => $id,
        ]);
        header("Location: manage_news.php");
        exit();
    } else {
        echo "<p style='color: red;'>Vui lòng điền đầy đủ thông tin.</p>";
    }
}

$sql = "SELECT * FROM news WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$news = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$news) {
    echo "<p style='color: red;'>Tin tức không tồn tại.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Tin Tức</title>
    <link rel="stylesheet" href="../css/add_news.css">
</head>

<body>
    <main>
        <div class="container">
            <h1>Sửa Tin Tức</h1>
            <form method="POST" action="" enctype="multipart/form-data">
                <label for="title">Tiêu đề:</label><br>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($news['title']); ?>" required><br>
                <label for="content">Nội dung:</label><br>
                <textarea name="content" id="content" rows="5" required><?php echo htmlspecialchars($news['content']); ?></textarea><br>
                <label for="category">Danh mục:</label><br>
                <input type="text" name="category" id="category" value="<?php echo htmlspecialchars($news['category']); ?>" required><br>
                <label for="image">Hình ảnh mới:</label><br>
                <input type="file" name="image" id="image" accept="image/*"><br>
                <?php if (!empty($news['image'])): ?>
                    <img src="../../uploads/news/<?php echo $news['image']; ?>" alt="Hình ảnh hiện tại" width="100"><br>
                <?php endif; ?>
                <br>
                <button type="submit" name="update_news">Cập Nhật</button>
            </form>
            <a href="manage_news.php">Quay lại quản lý tin tức</a>
        </div>
    </main>
</body>

</html>