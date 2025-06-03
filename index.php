<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // หากผู้ใช้ยังไม่ได้ล็อกอิน ให้กลับไปที่หน้า login
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบลงทะเบียนป้ายทะเบียนรถ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>ระบบลงทะเบียนป้ายทะเบียนรถ</h1>
        
        <div class="nav-buttons">
            <a href="register.html" class="nav-button">ลงทะเบียนป้ายทะเบียน</a>
            <a href="logout.php" class="nav-button">ออกจากระบบ</a>
        </div>
    </div>
</body>
</html>
