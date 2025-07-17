<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Calculater Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>
 
<body>
    <div class="container-fluid mt-3 mx-auto">
        <h1 class="text-center">PHP Calculater Money</h1>
        <hr>
        <p class="text-center">กรุณากรอกข้อมูลเพื่อทำการคำนวณยอดเงิน</p>
        <form action="" method="post" class="text-center mb-3">
            <div class="form-group row justify-content-center">
                <div class="col-md-4">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" id="price" name="Price"
                        value="<?php echo isset($_POST['Price']) ? $_POST['Price'] : ''; ?>"
                        class="form-control  mx-auto" placeholder="Enter a Price" required>
                </div>
                <div class="col-md-4">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" id="amount" name="Amount"
                        value="<?php echo isset($_POST['Amount']) ? $_POST['Amount'] : ''; ?>"
                        class="form-control  mx-auto" placeholder="Enter a Amount" required>
                </div>
            </div>
            <div class="mt-3 ">
                <label class="form-label d-block">membership ?</label>
                <div>
                    <input class="form-check-input form-check-inline" type="radio" name="member" id="member1" value="1" 
                        <?php echo (isset($_POST['member']) && $_POST['member'] == '1') ? 'checked' : ''; ?> >
                    <label class="form-check-label form-check-inline" for="member1">Member(10% Discount)</label>
                    <input class="form-check-input form-check-inline" type="radio" name="member" id="member0" value="0" 
                        <?php echo (isset($_POST['member']) && $_POST['member'] == '0') ? 'checked' : ''; ?>required>
                    <label class="form-check-label form-check-inline" for="member0">Not a Member</label>
 
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3 mb-3">Calculate</button>
            <button type="button" class="btn btn-secondary mt-3 mb-3" onclick="clear_form()">Reset All</button>
 
        </form>
        <div class="card mx-auto w-50">
            <div class="card-header bg-info text-light fw-bold text-center">Show Result</div>
            <ul class="list-group list-group-flush px-2 mt-2 " id="result">
                <?php
                //ตรวจสอบว่ามีการส่งข้อมูลมาหรือไม่
                if (isset($_POST['Price']) && isset($_POST['Amount']) && $_POST['Price'] !== '' && $_POST['Amount'] !== '') {
 
                    $get_price =  $_POST['Price'];
                    $get_amount =  $_POST['Amount'];
                    $total_paid = $get_price * $get_amount;
                    $total = $total_paid; // กำหนดค่าเริ่มต้นของ total เป็น total_paid
                    $discount = $total * 0.1; // 10% discount;
                    // ตรวจสอบว่ามีการเลือกสมาชิกหรือไม่
                    if (isset($_POST['member']) && $_POST['member'] == '1') {
                        $total_paid = $total_paid - $discount; // ลด 10% หากเป็นสมาชิก
                        echo '<li class="list-group-item">ราคาสินค้า: <b>' . number_format($get_price, 2) . '</b></li>';
                        echo '<li class="list-group-item">จำนวนสินค้า: <b>' . number_format($get_amount, 2) . '</b></li>';
                        echo '<li class="list-group-item">ยอดรวม: <b>' . number_format($total, 2) . '</b></li>';
                        echo '<li class="list-group-item">ส่วนลดที่ได้: <b>' . number_format($discount, 2) . '</b></li>';
                        echo '<li class="list-group-item text-primary">ยอดที่ต้องจ่ายหลังหักส่วนลด: <b>' . number_format($total_paid, 2) . '</b></li>';
                    } else {
                        $total_paid = $total; // ถ้าไม่เป็นสมาชิก ยอดที่ต้องจ่ายจะเท่ากับยอดรวม
                        echo '<li class="list-group-item">ราคาสินค้า: <b>' . number_format($get_price, 2) . '</b></li>';
                        echo '<li class="list-group-item">จำนวนสินค้า: <b>' . number_format($get_amount, 2) . '</b></li>';
                        echo '<li class="list-group-item">ยอดรวม: <b>' . number_format($total, 2) . '</b></li>';
                        echo '<li class="list-group-item text-primary">ยอดที่ต้องจ่าย: <b>' . number_format($total_paid, 2) . '</b></li>';
                    }
                } else {
                    echo "<div class='alert alert-warning'>Please input price and amount.</div>";
                }
                ?>
            </ul>
        </div>
        <script>
            function clear_form() {
                document.getElementById('price').value = '';
                document.getElementById('amount').value = '';
                document.getElementById('member1').checked = false;
                document.getElementById('member0').checked = true;
 
                document.getElementById('result').innerHTML = `<div class='alert alert-warning'>Please input price and amount.</div>`;
            }
        </script>
        <hr>
        <a href="index.php">
            <h5 class=" mt-1">Home</h5>
        </a>
 
    </div>
</body>
 
</html>