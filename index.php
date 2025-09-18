<?php
session_start();
require_once 'config.php';
$isLoggedIn = isset($_SESSION['user_id']);

$stmt = $pdo->query("SELECT p.*, c.category_name
FROM products p
LEFT JOIN categories c ON p.category_id = c.category_id
ORDER BY p.created_at DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>หน้าหลัก</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #e6fffa 0%, #f0fdfa 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .main-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .welcome-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
      padding: 2.5rem;
      text-align: center;
      max-width: 450px;
      width: 100%;
      border: 1px solid #d1fae5;
    }

    h1 {
      color: #0f766e;
      font-weight: 600;
      font-size: 2rem;
      margin-bottom: 1.5rem;
    }

    .user-info {
      background: linear-gradient(135deg, #99f6e4 0%, #5eead4 100%);
      color: #064e3b;
      padding: 1.2rem;
      border-radius: 8px;
      margin: 1.5rem 0;
      border-left: 4px solid #0d9488;
    }

    .user-info p {
      margin: 0;
      font-size: 1.1rem;
      font-weight: 500;
    }

    .user-icon {
      font-size: 2.5rem;
      color: #0d9488;
      margin-bottom: 1rem;
    }

    .btn-logout {
      background: #0d9488;
      border: none;
      padding: 10px 24px;
      border-radius: 6px;
      color: white;
      font-weight: 500;
      font-size: 1rem;
      transition: all 0.2s ease;
      text-decoration: none;
      display: inline-block;
    }

    .btn-logout:hover {
      background: #0f766e;
      color: white;
    }

    .welcome-text {
      color: #6b7280;
      font-size: 1rem;
      margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
      .welcome-card {
        padding: 2rem;
        margin: 1rem;
      }

      h1 {
        font-size: 1.8rem;
      }

      .user-info p {
        font-size: 1rem;
      }
    }
  </style>
  <style>
    .product-card {
      border: 1;
      background: #fff;
    }

    .product-thumb {
      height: 180px;
      object-fit: cover;
      border-radius: .5rem;
    }

    .product-meta {
      font-size: .75rem;
      letter-spacing: .05em;
      color: #8a8f98;
      text-transform: uppercase;
    }

    .product-title {
      font-size: 1rem;
      margin: .25rem 0 .5rem;
      font-weight: 600;
      color: #222;
    }

    .price {
      font-weight: 700;
    }

    .rating i {
      color: #ffc107;
    }

    /* ดำวสที อง */
    .wishlist {
      color: #b9bfc6;
    }

    .wishlist:hover {
      color: #ff5b5b;
    }

    .badge-top-left {
      position: absolute;
      top: .5rem;
      left: .5rem;
      z-index: 2;
      border-radius: .375rem;
    }

    .product-card {
      border: 1;
      background: #fff;
    }

    .product-thumb {
      height: 180px;
      object-fit: cover;
      border-radius: .5rem;
    }

    .product-meta {
      font-size: .75rem;
      letter-spacing: .05em;
      color: #8a8f98;
      text-transform: uppercase;
    }

    .product-title {
      font-size: 1rem;
      margin: .25rem 0 .5rem;
      font-weight: 600;
      color: #222;
    }

    .price {
      font-weight: 700;
    }

    .rating i {
      color: #ffc107;
    }

    /* ดำวสที อง */
    .wishlist {
      color: #b9bfc6;
    }

    .wishlist:hover {
      color: #ff5b5b;
    }

    .badge-top-left {
      position: absolute;
      top: .5rem;
      left: .5rem;
      z-index: 2;
      border-radius: .375rem;
    }
  </style>
</head>

<body class="container mt-4">
  </div>
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>รายการสินค้า</h1>
    <div>
      <?php
      if ($isLoggedIn): ?>
        <span class="me-3">ยินดีต้ออนรับ, <?= htmlspecialchars($_SESSION['username']) ?> (
          <?=
            $_SESSION['role'] ?>)
        </span>
        <a href="profile.php" class="btn btn-info">ข้อมูลส่วนตัว</a>
        <a href="cart.php" class="btn btn-warning">ดูตะกร้า</a>
        <a href="logout.php" class="btn btn-secondary">ออกจากระบบ</a>
      <?php else: ?>
        <a href="login.php" class="btn btn-success">เข้าสู่ระบบ</a>
        <a href="register.php" class="btn btn-primary">สมัครสมาชิก</a>
      <?php endif; ?>
    </div>
  </div>
  </div>
  </div>


  <!---รายการสั่งซื้อ--->
  <div class="row">
    <?php foreach ($products as $product): ?>
    <div class="col-md-4 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">
            <?= htmlspecialchars($product['product_name']) ?>
          </h5>
          <h6 class="card-subtitle mb-2 text-muted">
            <?= htmlspecialchars($แสดงชื่อหมวดหมู่จากdb) ?>
          </h6>
          <p class="card-text">
            <?= nl2br(htmlspecialchars($product['category_name'])) ?>
          </p>
          <p><strong>ราคา:</strong>
            <?= number_format($product['price']) ?> บาท
          </p>
          <?php if ($isLoggedIn): ?>
          <form action="cart.php" method="post" class="d-inline">
            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn btn-sm btn-success">เพิ่มในตะกร้า</button>
          </form>
          <?php else: ?>
          <small class="text-muted">เข้าสู่ระบบเพื่อสั่งซื้อ</small>
          <?php endif; ?>
          <a href="product_detail.php?id=<?= $product['product_id'] ?>"
            class="btn btn-sm btn-outline-primary float-end">ดูรายละเอียด</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- ===== สว่ นแสดงสนิ คำ้ ===== -->
  <div class="row g-4"> <!-- EDIT C -->
    <?php foreach ($products as $p): ?>
      <!-- TODO==== เตรียมรูป / ตกแต่ง badge / ดำวรีวิว ==== -->
      <?php
      // เตรียมรูป
      $img = !empty($p['image'])
        ? 'product_images/' . rawurlencode($p['image'])
        : 'product_images/no-image.jpg';
      // ตกแต่ง badge: NEW ภำยใน 7 วัน / HOT ถ ้ำสต็อกน้อยกว่ำ 5
      $isNew = isset($p['created_at']) && (time() - strtotime($p['created_at']) <= 7 * 24 * 3600);
      $isHot = (int) $p['stock'] > 0 && (int) $p['stock'] < 5;
      // ดำวรีวิว (ถ ้ำไม่มีใน DB จะโชว์ 4.5 จ ำลอง; ถ ้ำมี $p['rating'] ให้แทน)
      $rating = isset($p['rating']) ? (float) $p['rating'] : 4.5;
      $full = floor($rating); // จ ำนวนดำวเต็ม (เต็ม 1 ดวง) , floor ปัดลง
      $half = ($rating - $full) >= 0.5 ? 1 : 0; // มีดำวครึ่งดวงหรือไม่
      ?>
      <div class="col-12 col-sm-6 col-lg-3"> <!-- EDIT C -->
        <div class="card product-card h-100 position-relative"> <!-- EDIT C -->
          <!-- TODO====check $isNew / $isHot ==== -->
          <?php if ($isNew): ?>
            <span class="badge bg-success badge-top-left">NEW</span>
          <?php elseif ($isHot): ?>
            <span class="badge bg-danger badge-top-left">HOT</span>
          <?php endif; ?>
          <!-- TODO====show Product images ==== -->
          <a href="product_detail.php?id=<?= (int) $p['product_id'] ?>" class="p-3 d-block">
            <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($p['product_name']) ?>"
              class="img-fluid w-100 product-thumb">
          </a>
          <div class="px-3 pb-3 d-flex flex-column"> <!-- EDIT C -->
            <!-- TODO====div for category, heart ==== -->
            <div class="d-flex justify-content-between align-items-center mb-1">
              <div class="product-meta">
                <?= htmlspecialchars($p['category_name'] ?? 'Category') ?>
              </div>
              <button class="btn btn-link p-0 wishlist" title="Add to wishlist" type="button">
                <i class="bi bi-heart"></i>
              </button>
            </div>
            <!-- TODO====link, div for product name ==== -->
            <a class="text-decoration-none" href="product_detail.php?id=<?= (int) $p['product_id'] ?>">
              <div class="product-title">
                <?= htmlspecialchars($p['product_name']) ?>
              </div>
            </a>
            <!-- TODO====div for rating ==== -->
            <!-- ดำวรีวิว -->
            <div class="rating mb-2">
              <?php for ($i = 0; $i < $full; $i++): ?><i class="bi bi-star-fill"></i><?php endfor; ?>
              <?php if ($half): ?><i class="bi bi-star-half"></i><?php endif; ?>
              <?php for ($i = 0; $i < 5 - $full - $half; $i++): ?><i class="bi bi-star"></i><?php endfor; ?>
            </div>
            <!-- TODO====div for price ==== -->
            <div class="price mb-3">
              <?= number_format((float) $p['price'], 2) ?> บำท
            </div>
            <!-- TODO====div for button check login ==== -->
            <div class="mt-auto d-flex gap-2">
              <?php if ($isLoggedIn): ?>
                <form action="cart.php" method="post" class="d-inline-flex gap-2">
                  <input type="hidden" name="product_id" value="<?= (int) $p['product_id'] ?>">
                  <input type="hidden" name="quantity" value="1">
                  <button type="submit" class="btn btn-sm btn-success">เพิ่มในตะกร้า</button>
                </form>
              <?php else: ?>
                <small class="text-muted">เข้าสู่ระบบเพื่อสั่งซื้อ </small>
              <?php endif; ?>
              <a href="product_detail.php?id=<?= (int) $p['product_id'] ?>"
                class="btn btn-sm btn-outline-primary ms-auto">ดูรายละเอียด</a>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
  </script>
</body>

</html>