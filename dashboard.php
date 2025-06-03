<?php
session_start();
include 'config.php';
<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ตรวจสอบว่า user มีทะเบียนใน license_plates หรือไม่
$stmt = $pdo->prepare("SELECT * FROM license_plates WHERE user_id = ?");
$stmt->execute([$user_id]);
$plate_info = $stmt->fetch();

// ตรวจสอบว่ามีข้อมูลรถ (ในตาราง cars) ที่ตรงกับ plate_number หรือไม่
$car_info = null;
if ($plate_info) {
    $stmt2 = $pdo->prepare("SELECT * FROM cars WHERE plate_number = ?");
    $stmt2->execute([$plate_info['plate_number']]);
    $car_info = $stmt2->fetch();
}
?>
