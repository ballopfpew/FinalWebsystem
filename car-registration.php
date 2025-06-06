<?php
session_start();
include 'config.php';

// ตรวจสอบว่าเข้าสู่ระบบหรือยัง
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $plate_number = $_POST['plate_number'];
    $vehicle_owner = $_POST['vehicle_owner'];
    $vehicle_type = $_POST['vehicle_type'];
    $plate_province = $_POST['province']; // ✅ ชื่อที่ตรงกับฐานข้อมูล

    // บันทึกลงตาราง license_plates
    $stmt = $pdo->prepare("INSERT INTO license_plates 
        (plate_number, vehicle_owner, vehicle_type, plate_province, user_id) 
        VALUES (?, ?, ?, ?, ?)");

    if ($stmt->execute([$plate_number, $vehicle_owner, $vehicle_type, $plate_province, $user_id])) {
        header("Location: car-info.php");
        exit();
    } else {
        echo "<p style='color:red;'>เกิดข้อผิดพลาดในการบันทึกข้อมูล</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ลงทะเบียนข้อมูลรถ</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>
<body>
    <div class="container">
        <h1>ลงทะเบียนข้อมูลรถ</h1>
        <form action="car-registration.php" method="POST">
            <label for="plate_number">หมายเลขป้ายทะเบียน: (ตัวอย่าง 1กข999)</label>
            <input type="text" name="plate_number" id="plate_number" required>

            <label for="vehicle_owner">ชื่อเจ้าของรถ:</label>
            <input type="text" name="vehicle_owner" id="vehicle_owner" required>

            <label for="vehicle_type">ประเภทของรถ:</label>
            <select name="vehicle_type" id="vehicle_type" required>
                <option value="">เลือกประเภทของรถ</option>
                <option value="รถยนต์">รถยนต์</option>
                <option value="มอเตอร์ไซค์">มอเตอร์ไซค์</option>
                <option value="จักรยานยนต์">จักรยานยนต์</option>
                <option value="อื่นๆ">อื่นๆ</option>
            </select>

            <label for="province">จังหวัดของป้ายทะเบียน:</label>
<select name="province" id="province" class="js-example-basic-single" required>
    <option value="">เลือกจังหวัด</option>
    <option value="กรุงเทพมหานคร">กรุงเทพมหานคร</option>
    <option value="กระบี่">กระบี่</option>
    <option value="กาญจนบุรี">กาญจนบุรี</option>
    <option value="กาฬสินธุ์">กาฬสินธุ์</option>
    <option value="กำแพงเพชร">กำแพงเพชร</option>
    <option value="ขอนแก่น">ขอนแก่น</option>
    <option value="จันทบุรี">จันทบุรี</option>
    <option value="ฉะเชิงเทรา">ฉะเชิงเทรา</option>
    <option value="ชลบุรี">ชลบุรี</option>
    <option value="ชัยนาท">ชัยนาท</option>
    <option value="ชัยภูมิ">ชัยภูมิ</option>
    <option value="ชุมพร">ชุมพร</option>
    <option value="เชียงราย">เชียงราย</option>
    <option value="เชียงใหม่">เชียงใหม่</option>
    <option value="ตรัง">ตรัง</option>
    <option value="ตราด">ตราด</option>
    <option value="ตาก">ตาก</option>
    <option value="นครนายก">นครนายก</option>
    <option value="นครปฐม">นครปฐม</option>
    <option value="นครพนม">นครพนม</option>
    <option value="นครราชสีมา">นครราชสีมา</option>
    <option value="นครศรีธรรมราช">นครศรีธรรมราช</option>
    <option value="นครสวรรค์">นครสวรรค์</option>
    <option value="นนทบุรี">นนทบุรี</option>
    <option value="นราธิวาส">นราธิวาส</option>
    <option value="น่าน">น่าน</option>
    <option value="บึงกาฬ">บึงกาฬ</option>
    <option value="บุรีรัมย์">บุรีรัมย์</option>
    <option value="ปทุมธานี">ปทุมธานี</option>
    <option value="ประจวบคีรีขันธ์">ประจวบคีรีขันธ์</option>
    <option value="ปราจีนบุรี">ปราจีนบุรี</option>
    <option value="ปัตตานี">ปัตตานี</option>
    <option value="พระนครศรีอยุธยา">พระนครศรีอยุธยา</option>
    <option value="พะเยา">พะเยา</option>
    <option value="พังงา">พังงา</option>
    <option value="พัทลุง">พัทลุง</option>
    <option value="พิจิตร">พิจิตร</option>
    <option value="พิษณุโลก">พิษณุโลก</option>
    <option value="เพชรบุรี">เพชรบุรี</option>
    <option value="เพชรบูรณ์">เพชรบูรณ์</option>
    <option value="แพร่">แพร่</option>
    <option value="ภูเก็ต">ภูเก็ต</option>
    <option value="มหาสารคาม">มหาสารคาม</option>
    <option value="มุกดาหาร">มุกดาหาร</option>
    <option value="แม่ฮ่องสอน">แม่ฮ่องสอน</option>
    <option value="ยโสธร">ยโสธร</option>
    <option value="ยะลา">ยะลา</option>
    <option value="ร้อยเอ็ด">ร้อยเอ็ด</option>
    <option value="ระนอง">ระนอง</option>
    <option value="ระยอง">ระยอง</option>
    <option value="ราชบุรี">ราชบุรี</option>
    <option value="ลพบุรี">ลพบุรี</option>
    <option value="ลำปาง">ลำปาง</option>
    <option value="ลำพูน">ลำพูน</option>
    <option value="เลย">เลย</option>
    <option value="ศรีสะเกษ">ศรีสะเกษ</option>
    <option value="สกลนคร">สกลนคร</option>
    <option value="สงขลา">สงขลา</option>
    <option value="สตูล">สตูล</option>
    <option value="สมุทรปราการ">สมุทรปราการ</option>
    <option value="สมุทรสงคราม">สมุทรสงคราม</option>
    <option value="สมุทรสาคร">สมุทรสาคร</option>
    <option value="สระแก้ว">สระแก้ว</option>
    <option value="สระบุรี">สระบุรี</option>
    <option value="สิงห์บุรี">สิงห์บุรี</option>
    <option value="สุโขทัย">สุโขทัย</option>
    <option value="สุพรรณบุรี">สุพรรณบุรี</option>
    <option value="สุราษฎร์ธานี">สุราษฎร์ธานี</option>
    <option value="สุรินทร์">สุรินทร์</option>
    <option value="หนองคาย">หนองคาย</option>
    <option value="หนองบัวลำภู">หนองบัวลำภู</option>
    <option value="อ่างทอง">อ่างทอง</option>
    <option value="อำนาจเจริญ">อำนาจเจริญ</option>
    <option value="อุดรธานี">อุดรธานี</option>
    <option value="อุตรดิตถ์">อุตรดิตถ์</option>
    <option value="อุทัยธานี">อุทัยธานี</option>
    <option value="อุบลราชธานี">อุบลราชธานี</option>
</select>


            <button type="submit">ลงทะเบียนป้ายทะเบียน</button>
        </form>

        <a href="car-info.php" class="nav-button">ดูข้อมูลทะเบียนรถที่ลงทะเบียนแล้ว</a>
        <a href="logout.php" class="nav-button">ออกจากระบบ</a>
    </div>
</body>
</html>
