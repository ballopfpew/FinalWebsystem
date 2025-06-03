<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $faculty = $_POST['faculty'];
    $department = $_POST['department'];
    $student_id = $_POST['student_id'];
    $year = $_POST['year'];
    $year_of_study = $_POST['year_of_study'];
    $academic_year = $_POST['academic_year'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // เข้ารหัสรหัสผ่าน
    $role = 'user'; // กำหนดบทบาทเป็น user โดยอัตโนมัติ

    // เตรียมคำสั่ง SQL
    $stmt = $pdo->prepare("INSERT INTO users 
        (first_name, last_name, email, faculty, department, student_id, year, year_of_study, academic_year, password, role) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // ดำเนินการเพิ่มข้อมูล
    if ($stmt->execute([
        $first_name, $last_name, $email, $faculty, $department,
        $student_id, $year, $year_of_study, $academic_year, $password, $role
    ])) {
        header("Location: login.php");
        exit();
    } else {
        echo "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สมัครสมาชิก</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>สมัครสมาชิก</h1>
        <form action="signup.php" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">ชื่อ:</label>
                    <input type="text" name="first_name" id="first_name" required>
                </div>
                <div class="form-group">
                    <label for="last_name">นามสกุล:</label>
                    <input type="text" name="last_name" id="last_name" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">อีเมล:</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="form-group">
                    <label for="faculty">คณะ:</label>
                    <input type="text" name="faculty" id="faculty" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="department">สาขา:</label>
                    <input type="text" name="department" id="department" required>
                </div>
                <div class="form-group">
                    <label for="student_id">รหัสนักศึกษา:</label>
                    <input type="text" name="student_id" id="student_id" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="year">ปีที่เข้าศึกษา:</label>
                    <input type="number" name="year" id="year" required>
                </div>
                <div class="form-group">
                    <label for="year_of_study">ชั้นปี:</label>
                    <input type="text" name="year_of_study" id="year_of_study" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="academic_year">ปีการศึกษา:</label>
                    <input type="number" name="academic_year" id="academic_year" required>
                </div>
                <div class="form-group">
                    <label for="password">รหัสผ่าน:</label>
                    <input type="password" name="password" id="password" required>
                </div>
            </div>

            <button type="submit">สมัครสมาชิก</button>
        </form>
        <a href="login.php" class="nav-button">กลับสู่หน้าเข้าสู่ระบบ</a>
    </div>
</body>
</html>
