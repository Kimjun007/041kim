<?php
    require_once 'config.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = trim($_POST['username']);
        $fullname = trim($_POST['fullname']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        
        //ตรวจสอบข้อมูลมาครบหรือไม่ (emty)
        if(empty($username)|| empty($fullname)|| empty($email)|| empty($$password)|| empty($confirm_password)){
            $error[]="กรุณากรอกข้อมูลให้ครบทุกช่อง" ;
        }elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $error[]= "กรุณากรอกอีเมลให้ถูกต้อง";
        } elseif ($password !== $confirm_password) {
        $errors[] = "รหัสผ่ำนไม่ตรงกัน";
        }else{
            //ตอบสอบว่ามีชื่อผู้ใช้หรืออีเมลถูกใช้ไปแล้วหรือไม่
            $sql="SELECT * FROM users WHERE username = ? OR email = ?";
            $stmt = $conn->prepare($sql);
            $stmt ->execute([$username, $email]);
            if ($stmt->rowCount() > 0) {
                $errors[] = "ชื่อผู้ใช้หรืออีเมลนี้ถูกใช้ไปแล้ว";
            }
        }

        if(empty($error)){
            $hashedPassword = password_hash($password,PASSWORD_DEFAULT);
            $sql = "INSERT INTO users(username,full_name,emaill,password,role)VALUES (?,?,?,?,'member')";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username,$fullname,$email,$hashedPassword]);
            header("Location: login.php");
            exit();


        }






        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(username, full_name, email, password, role) VALUES (?, ?, ?, ?, 'admin')";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username, $fullname, $email, $hashedPassword]);
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5" >
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center bg-danger text-white">
                        <h2>Register</h2>

                            <?php if (!empty($error)): // ถ ้ำมีข ้อผิดพลำด ให้แสดงข ้อควำม ?>
                                <div class="alert alert-danger">
                                    <ul>
                                        <?php foreach ($errors as $e): ?>
                                            <li><?= htmlspecialchars($e) ?></li>
                                            <!--ใช ้ htmlspecialchars เพื่อป้องกัน XSS -->
                                            <!-- < ? = คือ short echo tag ?> -->
                                            <!-- ถ ้ำเขียนเต็ม จะได ้แบบด ้ำนล่ำง -->
                                            <?php // echo "<li>" . htmlspecialchars($e) . "</li>"; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                    </div>
                    <div class="card-body">
                        <form action="register.php" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">ชื่อผู้ใช้</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="ชื่อผู้ใช้ "value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?> required>
                            </div>
                            <div class="mb-3">
                                <label for="fullname" class="form-label">ชื่อ-สกุล</label>
                                <input type="text" name="fullname" id="fullname" class="form-control" placeholder="ชื่อ-สกุล" value="<?= isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : '' ?> required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">อีเมล</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="อีเมล" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?> required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">รหัสผ่าน</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="รหัสผ่าน" value="<?= isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '' ?> required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">ยืนยันรหัสผ่าน</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="ยืนยันรหัสผ่าน" value="<?= isset($_POST['confirm_password']) ? htmlspecialchars($_POST['confirm_password']) : '' ?> required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-danger">สมัครสมาชิก</button>
                                <a href="login.php" class="btn btn-link text-danger">เข้าสู่ระบบ</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>