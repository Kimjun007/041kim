<?php
session_start();
require ' '; // TODO: เชอื่ มตอ่ ฐำนขอ้ มลู ดว้ย PDO
// TODO: กำรด์ สทิ ธิ์(Admin Guard)
// แนวทำง: ถ ้ำ !isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin' -> redirect ไป ../login.php แล้ว exit;
if ( ) {
header("Location: ");
exit;
}
// เพมิ่ สนิคำ้ใหม่
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
$name = trim($_POST['ตัวแปรที่รับมำจำกฟอร์ม']);
$description = trim($_POST['ตัวแปรที่รับมำจำกฟอร์ม']);
$price = floatval($_POST['ตัวแปรที่รับมำจำกฟอร์ม']); // floatval() ใชแปลงเป็น ้ float
$stock = intval($_POST['ตัวแปรที่รับมำจำกฟอร์ม']); // intval() ใชแ้ปลงเป็น integer
$category_id = intval($_POST['ตัวแปรที่รับมำจำกฟอร์ม']);
// ค่ำที่ได ้จำกฟอร์มเป็น string เสมอ
if ($name && $price > 0) { // ตรวจสอบชอื่ และรำคำสนิ คำ้
    $imageName = null;

    if (!empty($_FILES['product_image']['name'])) {
        $file = $_FILES['product_image'];
        $allowed = ['image/jpeg', 'image/png'];

            if (in_array($file['type'], $allowed)) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $imageName = 'product_' . time() . '.' . $ext;
            $path = __DIR__ . '/../product_images/' . $imageName;
            move_uploaded_file($file['tmp_name'], $path);
}





$stmt = $pdo->prepare("INSERT INTO ตำรำง (ฟิลด์ที่ต ้องกำรเพิ่ม) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute([$ตัวแปรค่ำที่ต ้องกำร bind param]);
header("Location: products.php");
exit;
}
// ถ ้ำเขียนให ้อ่ำนง่ำยขึ้น สำมำรถเขียนแบบด ้ำนล่ำง
// if (!empty($name) && $price > 0) {
// // ผำ่ นเงอื่ นไข: มชี อื่ สนิคำ้ และ รำคำมำกกวำ่ 0
// }
}
// ลบสนิ คำ้
// if (isset($_GET['delete'])) {
// $product_id = $_GET['delete'];
// $stmt = $pdo->prepare("DELETE FROM ตำรำง WHERE product_id = ?");
// $stmt->execute([$ตัวแปรค่ำที่ต ้องกำร bind param]);
// header("Location: products.php");
// exit;
// }
// ลบสนิ คำ้ (ลบไฟลร์ปู ดว้ย)
if (isset($_GET['delete'])) {
$product_id = (int)$_GET['delete']; // แคสต์เป็น int
// 1) ดงึชอื่ ไฟลร์ปู จำก DB ก่อน
$stmt = $conn->prepare("SELECT image FROM products WHERE product_id = ?");
$stmt->execute([$product_id]);
$imageName = $stmt->fetchColumn(); // null ถ ้ำไม่มีรูป
// 2) ลบใน DB ด ้วย Transaction
try {
$pdo->beginTransaction();
$del = $conn->prepare("DELETE FROM products WHERE product_id = ?");
$del->execute([$product_id]);
$pdo->commit();
} catch (Exception $e) {
$pdo->rollBack();
// ใส่ flash message หรือ log ได ้ตำมต ้องกำร
header("Location: 68products.php");
exit;
}
// 3) ลบไฟล์รูปหลัง DB ลบส ำเร็จ
if ($imageName) {
$baseDir = realpath(__DIR__ . '/../product_images'); // โฟลเดอร์เก็บรูป
$filePath = realpath($baseDir . '/' . $imageName);
// กัน path traversal: ต ้องอยู่ใต้ $baseDir จริง ๆ
if ($filePath && strpos($filePath, $baseDir) === 0 && is_file($filePath)) {
@unlink($filePath); // ใช ้@ กัน warning ถำ้ลบไมส่ ำเร็จ
}
}
header("Location: 68products.php");
exit;
}



// ดงึรำยกำรสนิคำ้
// $stmt = $pdo->query("SELECT p.*, c.category_name FROM products p LEFT JOIN categories c ON
// p.category_id = c.category_id ORDER BY p.created_at DESC");
// $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
// ดึงหมวดหมู่
$categories = $pdo->query("SELECT * FROM ตำรำง")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>จัดกำรสนิคำ้</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">
</head>
<body class="container mt-4">
<h2>จัดกำรสนิ คำ้</h2>
<a href="index.php" class="btn btn-secondary mb-3">← กลับหน้ำผู้ดูแล</a>
<!-- ฟอรม์ เพมิ่ สนิคำ้ใหม่ -->
<form method="post" enctype="multipart/form-data" class="row g-3 mb-4">
<h5>เพมิ่ สนิคำ้ใหม</h ่ 5>
<div class="col-md-4">
<input type="text" name="product_name" class="form-control" placeholder="ชอื่ สนิคำ้"
required>
</div>
<div class="col-md-2">
<input type="number" step="0.01" name="price" class="form-control" placeholder="รำคำ"
required>
</div>
<div class="col-md-2">
<input type="number" name="stock" class="form-control" placeholder="จ ำนวน" required>
</div>
<div class="col-md-2">
<select name="category_id" class="form-select" required>
<option value="">เลือกหมวดหมู่</option>
<?php foreach ($ตัวแปรที่เก็บหมวดหมู่ as $cat): ?>
<option value="<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['ชอื่ หมวดหม'ู่])
?></option>
<?php endforeach; ?>
</select>
</div>
<div class="col-12">
<textarea name="description" class="form-control" placeholder="รำยละเอยีดสนิคำ้"
rows="2"></textarea>
</div>
<div class="col-12">
<button type="submit" name="add_product" class="btn btn-primary">เพิ่มสินค้า</button>
</div>
<div class="col-md-6">
<label class="form-label">รูปสินค้า (jpg, png)</label>
<input type="file" name="product_image" class="form-control">
</div>
</form>
<!-- แสดงรำยกำรสนิคำ้ , แก ้ไข , ลบ -->
<h5>รำยกำรสนิ คำ้</h5>
<table class="table table-bordered">
<thead>
<tr>
<th>ชอื่ สนิคำ้</th>
<th>หมวดหมู่</th>
<th>รำคำ</th>
<th>คงเหลือ</th>
<th>จัดกำร</th>
</tr>
</thead>
<tbody>
<?php foreach ($ตัวแปรเก็บสนิ คำ้ as $p): ?>
<tr>
<td><?= htmlspecialchars($p['ค่ำที่ต ้องกำรแสดง']) ?></td>
<td><?= htmlspecialchars($p['ค่ำที่ต ้องกำรแสดง']) ?></td>
<td><?= number_format($p['ค่ำที่ต ้องกำรแสดง'], 2) ?> บำท</td>
<td><?= $p['ค่ำที่ต ้องกำรแสดง'] ?></td>
<td>
<a href="products.php?delete=<?= $p['product_id'] ?>" class="btn btn-sm btn-danger"
onclick="return confirm('ยนื ยันกำรลบสนิคำ้นี้?')">ลบ</a>
<a href="edit_products.php?id=<?= $p['product_id'] ?>" class="btn btn-sm btnwarning">แก ้ไข</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</body>
</html>