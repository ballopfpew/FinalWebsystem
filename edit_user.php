<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// ตรวจสอบว่ามีการส่ง user_id หรือไม่
if (!isset($_GET['user_id'])) {
    echo "ไม่พบข้อมูลผู้ใช้";
    exit();
}

$user_id = $_GET['user_id'];

// ดึงข้อมูลผู้ใช้จากฐานข้อมูล
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "ไม่พบข้อมูลผู้ใช้นี้";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $faculty = $_POST['faculty'];
    $department = $_POST['department'];
    $student_id = $_POST['student_id'];
    $year = $_POST['year'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, faculty = ?, department = ?, student_id = ?, year = ?, password = ? WHERE user_id = ?");
    if ($stmt->execute([$first_name, $last_name, $email, $faculty, $department, $student_id, $year, $password, $user_id])) {
        header("Location: admin-dashboard.php");
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
    <title>แก้ไขข้อมูลผู้ใช้</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>แก้ไขข้อมูลผู้ใช้</h1>
        <form action="edit_user.php?user_id=<?php echo $user['user_id']; ?>" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">ชื่อ:</label>
                    <input type="text" name="first_name" id="first_name" value="<?php echo $user['first_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="last_name">นามสกุล:</label>
                    <input type="text" name="last_name" id="last_name" value="<?php echo $user['last_name']; ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">อีเมล:</label>
                    <input type="email" name="email" id="email" value="<?php echo $user['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="faculty">คณะ:</label>
                    <input type="text" name="faculty" id="faculty" value="<?php echo $user['faculty']; ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="department">สาขา:</label>
                    <input type="text" name="department" id="department" value="<?php echo $user['department']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="student_id">เลขประจำตัวนักศึกษา:</label>
                    <input type="text" name="student_id" id="student_id" value="<?php echo $user['student_id']; ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="year">ปีที่กำลังศึกษา:</label>
                    <input type="number" name="year" id="year" value="<?php echo $user['year']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">รหัสผ่าน (ตั้งใหม่):</label>
                    <input type="password" name="password" id="password" required>
                </div>
            </div>

            <button type="submit">บันทึกข้อมูล</button>
        </form>
        <a href="admin-dashboard.php" class="nav-button">กลับสู่หน้าแดชบอร์ด</a>
    </div>
</body>
</html>
