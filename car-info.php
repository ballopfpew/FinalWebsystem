<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM license_plates WHERE user_id = ?");
$stmt->execute([$user_id]);
$car_info = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลรถของคุณ</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
            color: #000;
        }
        th {
            background-color: #4CAF50;
            color: #000;
        }
        td {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>ข้อมูลรถของคุณ</h1>

    <?php if (!empty($car_info)): ?>
        <table>
            <thead>
                <tr>
                    <th>หมายเลขป้ายทะเบียน</th>
                    <th>ชื่อเจ้าของรถ</th>
                    <th>ประเภทของรถ</th>
                    <th>จังหวัด</th> <!-- เพิ่มหัวตาราง -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($car_info as $car): ?>
                    <tr>
                        <td><?= htmlspecialchars($car['plate_number']); ?></td>
                        <td><?= htmlspecialchars($car['vehicle_owner']); ?></td>
                        <td><?= htmlspecialchars($car['vehicle_type']); ?></td>
                        <td><?= htmlspecialchars($car['plate_province']); ?></td> <!-- แสดงจังหวัด -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>คุณยังไม่ได้ลงทะเบียนข้อมูลรถ</p>
    <?php endif; ?>

    <a href="logout.php" class="nav-button">ออกจากระบบ</a>
</div>
</body>
</html>
