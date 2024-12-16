<?php
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $gender = $_POST['gender'];
    $security_question = isset($_POST['security_question']) ? $_POST['security_question'] : null;
    $security_answer = isset($_POST['security_answer']) ? $_POST['security_answer'] : null;

    // Kiểm tra mật khẩu khớp nhau
    if ($password !== $confirm_password) {
        echo "Mật khẩu nhập lại không khớp!";
        exit;
    }

    // Kiểm tra câu hỏi bảo mật
    if (empty($security_question) || empty($security_answer)) {
        echo "Vui lòng nhập câu hỏi và câu trả lời bảo mật!";
        exit;
    }

    // Kiểm tra email hợp lệ
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email không hợp lệ!";
        exit;
    }

    // Mã hóa mật khẩu và câu trả lời bảo mật
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $hashed_answer = password_hash($security_answer, PASSWORD_DEFAULT);

    // Mặc định vai trò là người dùng
    $role = 'user';

    try {
        $pdo->beginTransaction(); // Bắt đầu transaction

        // Kiểm tra tên đăng nhập hoặc email đã tồn tại
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            echo "Tên đăng nhập hoặc email đã tồn tại!";
            exit;
        }

        // Thêm tài khoản vào bảng users
        $stmt = $pdo->prepare("INSERT INTO users (fullname, username, email, password, gender, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$fullname, $username, $email, $hashed_password, $gender, $role]);

        // Lấy ID của người dùng vừa tạo
        $user_id = $pdo->lastInsertId();

        // Thêm câu hỏi bảo mật vào bảng security_questions
        $stmt = $pdo->prepare("INSERT INTO security_questions (user_id, question, answer) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $security_question, $hashed_answer]);

        $pdo->commit(); // Xác nhận transaction

        echo "<script>
                window.onload = function() {
                    showSuccessMessage('Đăng ký thành công! <a href=\"login.php\">Đăng nhập</a>');
                }
              </script>";
    } catch (PDOException $e) {
        $pdo->rollBack(); // Rollback nếu có lỗi
        echo "Lỗi: " . $e->getMessage();
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
                <label for="security_question" class="form-label">Nhập câu hỏi bảo mật</label>
                <input id="security_question" name="security_question" type="text" placeholder="Nhập câu hỏi bảo mật của bạn" class="form-control" required>
                <span class="form-message"></span>
            </div>

            <div class="form-group">
                <label for="security_answer" class="form-label">Câu trả lời bảo mật</label>
                <input id="security_answer" name="security_answer" type="text" placeholder="Nhập câu trả lời bảo mật" class="form-control" required>
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