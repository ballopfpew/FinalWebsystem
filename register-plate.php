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
    $vehicle_owner = $_POST['vehicle_owner'];
    $vehicle_type = $_POST['vehicle_type'];
    $plate_province = $_POST['plate_province'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO license_plates 
        (plate_number, vehicle_owner, vehicle_type, plate_province, user_id) 
        VALUES (?, ?, ?, ?, ?)");

    if ($stmt->execute([$plate_number, $vehicle_owner, $vehicle_type, $plate_province, $user_id])) {
        echo "<p style='color:green;'>บันทึกป้ายทะเบียนสำเร็จ!</p>";
    } else {
        echo "<p style='color:red;'>เกิดข้อผิดพลาดในการบันทึกป้ายทะเบียน</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เพิ่มป้ายทะเบียน</title>
</head>
<body>
    <h2>เพิ่มข้อมูลป้ายทะเบียน</h2>
    <form action="register-plate.php" method="POST">
        <label for="plate_number">หมายเลขทะเบียน:</label><br>
        <input type="text" name="plate_number" id="plate_number" required><br><br>

        <label for="vehicle_owner">ชื่อเจ้าของรถ:</label><br>
        <input type="text" name="vehicle_owner" id="vehicle_owner" required><br><br>

        <label for="vehicle_type">ประเภทรถ:</label><br>
        <input type="text" name="vehicle_type" id="vehicle_type" required><br><br>

        <label for="plate_province">จังหวัด:</label><br>
        <input type="text" name="plate_province" id="plate_province" required><br><br>

        <button type="submit">บันทึกป้ายทะเบียน</button>
    </form>
</body>
</html>
