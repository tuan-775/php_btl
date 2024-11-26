<?php
$host = 'localhost'; // Tên máy chủ
$dbname = 'rabitydb'; // Tên cơ sở dữ liệu của bạn
$username = 'root'; // Tên người dùng cơ sở dữ liệu
$password = ''; // Mật khẩu cơ sở dữ liệu

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage());
}
?>
