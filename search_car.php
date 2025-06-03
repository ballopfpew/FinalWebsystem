<?php
session_start();
include 'config.php';

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// หากมีการค้นหาผ่านฟอร์ม
$plate_number = '';
$cars = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $plate_number = $_POST['plate_number'];
    
    // ค้นหาข้อมูลรถตามหมายเลขป้ายทะเบียน
    $stmt = $pdo->prepare("SELECT * FROM cars WHERE plate_number LIKE ?");
    $stmt->execute([$plate_number . '%']);
    $cars = $stmt->fetchAll();
}

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ค้นหาข้อมูลรถ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>ค้นหาข้อมูลรถ</h1>

        <!-- ฟอร์มค้นหาข้อมูลรถ -->
        <form method="POST" action="search_car.php">
            <label for="plate_number">หมายเลขป้ายทะเบียน:</label>
            <input type="text" name="plate_number" id="plate_number" value="<?php echo $plate_number; ?>" required>
            <button type="submit">ค้นหา</button>
        </form>

        <!-- แสดงผลการค้นหา -->
        <?php if (!empty($cars)): ?>
        <h2>ผลลัพธ์การค้นหา</h2>
        <table>
            <thead>
                <tr>
                    <th>หมายเลขป้ายทะเบียน</th>
                    <th>เจ้าของรถ</th>
                    <th>ประเภทของรถ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cars as $car): ?>
                <tr>
                    <td><?php echo $car['plate_number']; ?></td>
                    <td><?php echo $car['owner']; ?></td>
                    <td><?php echo $car['car_type']; ?></td>
                    <a href="edit_car.php?car_id=<?php echo $car['car_id']; ?>">แก้ไข</a>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p>ไม่พบข้อมูลรถที่ค้นหา</p>
        <?php endif; ?>
        
        <!-- ปุ่มกลับไปยังหน้าแดชบอร์ด -->
        <a href="admin-dashboard.php" class="nav-button">กลับไปยังแดชบอร์ด</a>
    </div>
</body>
</html>
