<?php
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $gender = $_POST['gender'];

    // Kiểm tra mật khẩu khớp nhau
    if ($password !== $confirm_password) {
        echo "Mật khẩu nhập lại không khớp!";
        exit;
    }

    // Mã hóa mật khẩu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Mặc định vai trò là người dùng
    $role = 'user';

    // Thêm tài khoản vào cơ sở dữ liệu
    $stmt = $pdo->prepare("INSERT INTO users (fullname, username, email, password, gender, role) VALUES (?, ?, ?, ?, ?, ?)");
    try {
        $stmt->execute([$fullname, $username, $email, $hashed_password, $gender, $role]);
        echo "<script>
                window.onload = function() {
                    showSuccessMessage('Đăng ký thành công! <a href=\"login.php\">Đăng nhập</a>');
                }
              </script>";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "Tên đăng nhập hoặc email đã tồn tại!";
        } else {
            echo "Lỗi: " . $e->getMessage();
        }
    }
}
?>

<link rel="stylesheet" href="../css/register.css">

<body>
    <div class="main">

        <form action="" method="POST" class="form" id="form-1">
            <h3 class="heading"> Đăng ký</h3>

            <div class="spacer"></div>

            <div class="form-group">
                <label for="fullname" class="form-label">Tên đầy đủ</label>
                <input id="fullname" name="fullname" type="text" placeholder="VD: Phạm Quang Tuấn" class="form-control">
                <span class="form-message"></span>
            </div>

            <div class="form-group">
                <label for="username" class="form-label">Tên đăng nhập</label>
                <input id="username" name="username" type="text" placeholder="VD: email@domain.com" class="form-control">
                <span class="form-message"></span>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" name="email" type="text" placeholder="VD: email@domain.com" class="form-control">
                <span class="form-message"></span>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Mật khẩu</label>
                <input id="password" name="password" type="password" placeholder="Nhập mật khẩu" class="form-control">
                <span class="form-message"></span>
            </div>

            <div class="form-group">
                <label for="confirm_password" class="form-label">Nhập lại mật khẩu</label>
                <input id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu"
                    type="password" class="form-control">
                <span class="form-message"></span>
            </div>

            <div class="form-group">
                <label for="gender" class="form-label">Giới tính</label>
                <div class="form-group_sex">
                    <input name="gender" type="radio" value="Nam" class="form-control">Nam
                </div>
                <div class="form-group_sex">
                    <input name="gender" type="radio" value="Nữ" class="form-control">Nữ
                </div>
                <div class="form-group_sex">
                    <input name="gender" type="radio" value="Khác" class="form-control">Khác
                </div>
            </div>
            <button class="form-submit" type="submit">Đăng ký</button>
            <span class="form-message"></span>
    </div>
    </form>
    </div>

    <div id="success-popup" class="popup">
        <div class="popup-content">
            <span class="popup-close" onclick="closePopup()">&times;</span>
            <div class="success-icon">&#10003;</div>
            <h2>Đăng ký thành công</h2>
            <a href="#" class="close-btn" onclick="closePopup()">Tôi Đã Hiểu</a>
        </div>
    </div>

    <script>
        // JavaScript để hiển thị thông báo
        function showSuccessMessage(message) {
            document.getElementById('popup-message').innerHTML = message;
            document.getElementById('success-popup').style.display = 'flex';
        }

        // Đóng Popup
        function closePopup() {
            document.getElementById('success-popup').style.display = 'none';
        }
    </script>
    <!-- <script src="../js/validateFormRegister.js"></script>
    <script>
        Validator({
            form: '#form-1',
            formGroupSelector: '.form-group',
            errorSelector: '.form-message',
            rules: [
                Validator.isRequired('#fullname', 'Vui long nhap day du ho ten'),
                Validator.isEmail('#email'),
                Validator.isRequired('#password', 6),
                Validator.isRequired('#password_confirmation'),
                Validator.isRequired('input[name="gender"]'),
                Validator.isConfirmed('#password_confirmation', function() {
                    return document.querySelector('#form-1 #password').value;
                }, 'Mật khẩu nhập lại không đúng'),
            ],
            onSubmit: function(data) {
                // call API
                // console.log(data);
            }
        });
    </script> -->
</body>