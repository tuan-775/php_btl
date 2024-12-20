<?php
// Kết nối đến cơ sở dữ liệu thông qua db.php
include '../db.php';

// Xử lý thêm, sửa, xóa
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $sql = "INSERT INTO categories (name) VALUES (:name)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['name' => $name]);
    } elseif (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $sql = "UPDATE categories SET name = :name WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['name' => $name, 'id' => $id]);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
}

// Lấy danh sách danh mục
$sql = "SELECT * FROM categories";
$stmt = $pdo->query($sql);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Quản lý Danh mục</title>
    <link rel="stylesheet" href="./css/manage_subcategories.css">
</head>

<body>
    <h1>Quản lý Danh mục</h1>

    <h2>Thêm Danh mục</h2>
    <main>
        <form method="POST">
            <input type="text" name="name" placeholder="Tên Danh mục" required>
            <button type="submit" name="add">Thêm</button>
        </form>

        <h2>Danh sách Danh mục</h2>
        <a href="./dashboard.php">Quay lại Quản trị</a>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Hành động</th>
            </tr>
            <?php foreach ($categories as $category) { ?>
                <tr>
                    <form method="POST">
                        <td><?php echo $category['id']; ?></td>
                        <td><input type="text" name="name" value="<?php echo $category['name']; ?>"></td>
                        <td>
                            <button type="submit" name="edit" value="1">Sửa</button>
                            <button type="submit" name="delete" value="1" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
                        </td>
                        <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                    </form>
                </tr>
            <?php } ?>
        </table>
    </main>
</body>

</html>