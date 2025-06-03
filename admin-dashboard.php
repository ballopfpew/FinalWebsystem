<?php
session_start();
include 'config.php';

// ตรวจสอบว่าเป็น admin หรือไม่
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll();

$stmt2 = $pdo->query("SELECT * FROM license_plates");
$plates = $stmt2->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แผงควบคุมผู้ดูแล</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container1">
        <h1>ยินดีต้อนรับ, <?php echo $_SESSION['first_name']; ?>!</h1>

        <!-- ตารางผู้ใช้ -->
        <h2>ข้อมูลผู้ใช้ทั้งหมด</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ชื่อ</th>
                    <th>อีเมล</th>
                    <th>คณะ</th>
                    <th>สาขา</th>
                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                        <td><?= htmlspecialchars($user['faculty']); ?></td>
                        <td><?= htmlspecialchars($user['department']); ?></td>
                        <td><?= htmlspecialchars($user['role']); ?></td>
                        <td>
                            <a href="edit_user.php?user_id=<?= $user['user_id']; ?>">แก้ไข</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="car-registration-data.php" class="nav-button">ข้อมูลการลงทะเบียนรถ</a>
        <a href="logout.php" class="nav-button">ออกจากระบบ</a>
    </div>
</body>
</html>