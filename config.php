<?php
$host = 'localhost';  // ชื่อเครื่องเซิร์ฟเวอร์ (ในกรณีนี้คือ localhost)
$dbname = 'car_registration';  // ชื่อฐานข้อมูล
$username = 'root';  // ชื่อผู้ใช้ฐานข้อมูล
$password = '';  // รหัสผ่านฐานข้อมูล (ถ้าไม่ได้ตั้งรหัสผ่านให้เว้นว่างไว้)

try {
    // การเชื่อมต่อฐานข้อมูล
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
