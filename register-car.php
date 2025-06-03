<?php
include 'config.php';
session_start();

// ต้อง login ก่อน
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $plate_number = $_POST['plate_number'];
    $owner = $_POST['owner'];
    $car_type = $_POST['car_type'];
    $registration_date = $_POST['registration_date'];

    $stmt = $pdo->prepare("INSERT INTO cars 
        (plate_number, owner, car_type, registration_date) 
        VALUES (?, ?, ?, ?)");

    if ($stmt->execute([$plate_number, $owner, $car_type, $registration_date])) {
        echo "<p style='color:green;'>บันทึกข้อมูลรถสำเร็จ!</p>";
    } else {
        echo "<p style='color:red;'>เกิดข้อผิดพลาดในการบันทึกข้อมูลรถ</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เพิ่มข้อมูลรถยนต์</title>
</head>
<body>
    <h2>เพิ่มข้อมูลรถยนต์</h2>
    <form action="register-car.php" method="POST">
        <label for="plate_number">หมายเลขทะเบียน (ต้องกรอกมาก่อนหน้านี้):</label><br>
        <input type="text" name="plate_number" id="plate_number" required><br><br>

        <label for="owner">ชื่อเจ้าของรถ:</label><br>
        <input type="text" name="owner" id="owner" required><br><br>

        <label for="car_type">ประเภทรถ:</label><br>
        <input type="text" name="car_type" id="car_type" required><br><br>

        <label for="registration_date">วันที่จดทะเบียน:</label><br>
        <input type="date" name="registration_date" id="registration_date" required><br><br>

        <button type="submit">บันทึกข้อมูลรถ</button>
    </form>
</body>
</html>

