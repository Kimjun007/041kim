<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>จัดกำรหมวดหมู่</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
<h2>จัดกำรหมวดหมสู่ นิ คำ้</h2>
<?php if (isset($_SESSION['error'])): ?>
<div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
<?php unset($_SESSION['error']); ?>
<?php endif; ?>
<?php if (isset($_SESSION['success'])): ?>
<div class="alert alert-success"><?= $_SESSION['success'] ?></div>
<?php unset($_SESSION['success']); ?>
<?php endif; ?>
<a href="index.php" class="btn btn-secondary mb-3">← กลับหน้าผู้ดูแล</a>
<form method="post" class="row g-3 mb-4">
<div class="col-md-6">
<input type="text" name="category_name" class="form-control" placeholder="ชอื่ หมวดหมใู่ หม"่ required>
</div>
<div class="col-md-2">
<button type="submit" name="add_category" class="btn btn-primary">เพิ่มหมวดหมู่</button>
</div>
</form>
<h5>รำยกำรหมวดหมู่</h5>
<table class="table table-bordered">
<thead>
<tr>
<th>ชอื่ หมวดหม</th> ู่
<th>แกไ้ขชอื่ </th>
<th>จัดกำร</th>
</tr>
</thead>
<tbody>
<?php foreach ($ตัวแปรที่เก็บค่ำข ้อมูลที่ดึงขึ้นมำ as $cat): ?>
<tr>
<td><?= htmlspecialchars($cat['ชอื่ หมวดหม'ู่]) ?></td>
<td>
<form method="post" class="d-flex">
<input type="hidden" name="category_id" value="<?= $cat['id หมวดหมู่'] ?>">
<input type="text" name="new_name" class="form-control me-2" placeholder="ชอื่ ใหม"่
required>
<button type="submit" name="update_category" class="btn btn-sm btn-warning">แก ้ไข
</button>
</form>
</td>
<td>
<a href="categories.php?delete=<?= $cat[' id หมวดหมู่'] ?>" class="btn btn-sm btn-danger"
onclick="return confirm('คุณต ้องกำรลบหมวดหมู่นี้หรือไม่?')">ลบ</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</body>
</html>