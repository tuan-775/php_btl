<?php
// Kết nối đến cơ sở dữ liệu thông qua db.php
include '../db.php';

// Lấy danh sách danh mục để thêm vào loại sản phẩm
$sql = "SELECT * FROM categories";
$stmt = $pdo->query($sql);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Xử lý thêm, sửa, xóa
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $category_id = $_POST['category_id'];
        $sql = "INSERT INTO subcategories (name, category_id) VALUES (:name, :category_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['name' => $name, 'category_id' => $category_id]);
    } elseif (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $category_id = $_POST['category_id'];
        $sql = "UPDATE subcategories SET name = :name, category_id = :category_id WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['name' => $name, 'category_id' => $category_id, 'id' => $id]);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM subcategories WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
}

// Lấy danh sách loại sản phẩm
$sql = "SELECT subcategories.*, categories.name AS category_name 
        FROM subcategories 
        JOIN categories ON subcategories.category_id = categories.id";
$stmt = $pdo->query($sql);
$subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quản lý Loại sản phẩm</title>
</head>
<body>
    <h1>Quản lý Loại sản phẩm</h1>

    <h2>Thêm Loại sản phẩm</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Tên Loại sản phẩm" required>
        <select name="category_id" required>
            <option value="">Chọn Danh mục</option>
            <?php foreach ($categories as $category) { ?>
                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
            <?php } ?>
        </select>
        <button type="submit" name="add">Thêm</button>
    </form>

    <h2>Danh sách Loại sản phẩm</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Danh mục</th>
            <th>Hành động</th>
        </tr>
        <?php foreach ($subcategories as $subcategory) { ?>
        <tr>
            <form method="POST">
                <td><?php echo $subcategory['id']; ?></td>
                <td><input type="text" name="name" value="<?php echo $subcategory['name']; ?>"></td>
                <td>
                    <select name="category_id">
                        <?php foreach ($categories as $category) { ?>
                            <option value="<?php echo $category['id']; ?>" 
                                <?php echo $category['id'] == $subcategory['category_id'] ? 'selected' : ''; ?>>
                                <?php echo $category['name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <button type="submit" name="edit" value="1">Sửa</button>
                    <button type="submit" name="delete" value="1" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
                </td>
                <input type="hidden" name="id" value="<?php echo $subcategory['id']; ?>">
            </form>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
