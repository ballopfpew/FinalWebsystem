<?php
session_start();
include 'config.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าเป็น POST request หรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // ค้นหาผู้ใช้ในฐานข้อมูลตามอีเมล
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // ตรวจสอบว่าอีเมลและรหัสผ่านถูกต้องหรือไม่
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['first_name'] = $user['first_name'];

        // ถ้าล็อกอินสำเร็จ ให้ไปที่หน้า dashboard หรือหน้าอื่น ๆ
        header("Location: dashboard.php");
        exit();
    } else {
        echo "อีเมลหรือรหัสผ่านไม่ถูกต้อง!";
    }
}
?>
