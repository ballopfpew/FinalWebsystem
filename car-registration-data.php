<?php
// เริ่มต้น session
session_start();

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// เชื่อมต่อฐานข้อมูล
include 'config.php';

// ดึงข้อมูลป้ายทะเบียนรถทั้งหมดจากฐานข้อมูล
$stmt = $pdo->query("SELECT * FROM license_plates");  // สั่งดึงข้อมูลทั้งหมดจากตาราง cars
$plates = $stmt->fetchAll();  // ดึงข้อมูลทั้งหมดในรูปแบบ array

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลป้ายทะเบียนรถ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container1">
        <h2 style="margin-top: 50px;">ข้อมูลป้ายทะเบียนรถทั้งหมด</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>หมายเลขทะเบียน</th>
                    <th>เจ้าของรถ</th>
                    <th>ประเภท</th>
                    <th>จังหวัด</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($plates as $plate): ?>
                    <tr>
                        <td><?= htmlspecialchars($plate['plate_number']); ?></td>
                        <td><?= htmlspecialchars($plate['vehicle_owner']); ?></td>
                        <td><?= htmlspecialchars($plate['vehicle_type']); ?></td>
                        <td><?= htmlspecialchars($plate['plate_province']); ?></td>
                        <td>
                            <a href="edit_plate.php?plate_id=<?= $plate['plate_id']; ?>">แก้ไข</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <a href="admin-dashboard.php" class="nav-button">กลับหน้าก่อนหน้า</a>               
        <a href="logout.php" class="nav-button">ออกจากระบบ</a>
    </div>
</body>
</html>
