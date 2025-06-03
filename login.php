<?php
session_start();
include 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['first_name'] = $user['first_name'];

        if ($user['role'] == 'admin') {
            $_SESSION['role'] = 'admin';
            header("Location: admin-dashboard.php");
            exit();
        } else {
            $_SESSION['role'] = 'user';
            header("Location: car-registration.php");
            exit();
        }
    } else {
        $error = "อีเมลหรือรหัสผ่านไม่ถูกต้อง!";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom right, #3498db, #f1c40f);
            font-family: sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            color: white;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
        }

        .error {
            color: #ffdddd;
            background-color: #ff4d4d;
            padding: 8px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-login {
            background-color: #28a745;
            color: white;
        }

        .btn-register {
            background-color: #007bff;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>เข้าสู่ระบบ</h2>

    <form action="login.php" method="POST">
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="form-group">
            <label for="email">อีเมล:</label>
            <input type="email" name="email" id="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="password">รหัสผ่าน:</label>
            <input type="password" name="password" id="password" required>
        </div>

        <button type="submit" class="btn btn-login">เข้าสู่ระบบ</button>
        <a href="signup.php" class="btn btn-register" style="text-align:center; text-decoration:none;">สมัครสมาชิก</a>
    </form>
</div>

</body>
</html>
