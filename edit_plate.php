<?php
session_start();
include 'config.php';

// ตรวจสอบการเข้าถึงจาก URL ผ่าน plate_id
if (!isset($_GET['plate_id'])) {
    echo "ไม่พบข้อมูลป้ายทะเบียน!";
    exit();
}

$plate_id = $_GET['plate_id'];

// ดึงข้อมูลทะเบียนรถจากฐานข้อมูล
$stmt = $pdo->prepare("SELECT * FROM license_plates WHERE plate_id = ?");
$stmt->execute([$plate_id]);
$plate = $stmt->fetch();

if (!$plate) {
    echo "ไม่พบข้อมูลป้ายทะเบียนนี้!";
    exit();
}

// อัปเดตข้อมูลทะเบียนรถ
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $plate_number = $_POST['plate_number'];
    $vehicle_owner = $_POST['vehicle_owner'];
    $vehicle_type = $_POST['vehicle_type'];

    $update_stmt = $pdo->prepare("UPDATE license_plates SET plate_number = ?, vehicle_owner = ?, vehicle_type = ? WHERE plate_id = ?");
    $update_stmt->execute([$plate_number, $vehicle_owner, $vehicle_type, $plate_id]);

    header("Location: admin-dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขข้อมูลทะเบียนรถ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>แก้ไขข้อมูลทะเบียนรถ</h1>
        <form action="edit_plate.php?plate_id=<?php echo $plate['plate_id']; ?>" method="POST">
            <label for="plate_number">หมายเลขป้ายทะเบียน:</label>
            <input type="text" name="plate_number" value="<?php echo $plate['plate_number']; ?>" required><br>

            <label for="vehicle_owner">ชื่อเจ้าของรถ:</label>
            <input type="text" name="vehicle_owner" value="<?php echo $plate['vehicle_owner']; ?>" required><br>

            <label for="vehicle_type">ประเภทของรถ:</label>
            <input type="text" name="vehicle_type" value="<?php echo $plate['vehicle_type']; ?>" required><br>
            <label for="plate_province">จังหวัดของป้ายทะเบียน:</label>
<select name="plate_province" id="plate_province" required>
    <option value="">เลือกจังหวัด</option>
    <?php
    $provinces = [
        "กรุงเทพมหานคร", "กระบี่", "กาญจนบุรี", "กาฬสินธุ์", "กำแพงเพชร", "ขอนแก่น",
        "จันทบุรี", "ฉะเชิงเทรา", "ชลบุรี", "ชัยนาท", "ชัยภูมิ", "ชุมพร", "เชียงราย", "เชียงใหม่",
        "ตรัง", "ตราด", "ตาก", "นครนายก", "นครปฐม", "นครพนม", "นครราชสีมา", "นครศรีธรรมราช",
        "นครสวรรค์", "นนทบุรี", "นราธิวาส", "น่าน", "บึงกาฬ", "บุรีรัมย์", "ปทุมธานี", "ประจวบคีรีขันธ์",
        "ปราจีนบุรี", "ปัตตานี", "พระนครศรีอยุธยา", "พะเยา", "พังงา", "พัทลุง", "พิจิตร", "พิษณุโลก",
        "เพชรบุรี", "เพชรบูรณ์", "แพร่", "ภูเก็ต", "มหาสารคาม", "มุกดาหาร", "แม่ฮ่องสอน", "ยโสธร",
        "ยะลา", "ร้อยเอ็ด", "ระนอง", "ระยอง", "ราชบุรี", "ลพบุรี", "ลำปาง", "ลำพูน", "เลย",
        "ศรีสะเกษ", "สกลนคร", "สงขลา", "สตูล", "สมุทรปราการ", "สมุทรสงคราม", "สมุทรสาคร",
        "สระแก้ว", "สระบุรี", "สิงห์บุรี", "สุโขทัย", "สุพรรณบุรี", "สุราษฎร์ธานี", "สุรินทร์",
        "หนองคาย", "หนองบัวลำภู", "อ่างทอง", "อำนาจเจริญ", "อุดรธานี", "อุตรดิตถ์",
        "อุทัยธานี", "อุบลราชธานี"
    ];
    foreach ($provinces as $province) {
        $selected = ($plate['plate_province'] == $province) ? 'selected' : '';
        echo "<option value=\"$province\" $selected>$province</option>";
    }
    ?>
</select>


            <button type="submit">อัปเดตข้อมูล</button>
        </form>
        <a href="admin-dashboard.php" class="nav-button">กลับสู่หน้าผู้ดูแล</a>
    </div>
</body>
</html>
