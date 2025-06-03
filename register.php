<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $faculty = $_POST['faculty'];
    $department = $_POST['department'];
    $student_id = $_POST['student_id'];
    $year_of_study = $_POST['year_of_study'];  // ปีการศึกษา
    $academic_year = $_POST['academic_year'];  // ชั้นปี
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // ตรวจสอบข้อมูลที่จำเป็น
    if (empty($first_name) || empty($last_name) || empty($email) || empty($faculty) || empty($department) || empty($student_id) || empty($year_of_study) || empty($academic_year) || empty($password)) {
        die('กรุณากรอกข้อมูลให้ครบ');
    }

    // ตรวจสอบว่าอีเมลนี้มีการใช้งานแล้วหรือไม่
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        die('อีเมลนี้ถูกใช้งานแล้ว');
    }

    // เพิ่มข้อมูลผู้ใช้ลงในฐานข้อมูล
    $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, faculty, department, student_id, year_of_study, academic_year, password) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$first_name, $last_name, $email, $faculty, $department, $student_id, $year_of_study, $academic_year, $password]);

    // เมื่อสมัครเสร็จจะเปลี่ยนเส้นทางไปยังหน้า Login
    header("Location: login.php");
    exit();
}
?>
