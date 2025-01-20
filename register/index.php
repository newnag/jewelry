<?php
    include('functions/check-login.php');
?>

<?php
    $type_regis = $_GET['type'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thavorn Jewelry</title>

    <link rel="stylesheet" href="../css/register.min.css?v=1.02">
</head>
<body>
    <div class="login">
        <div class="left">
            <div class="logo">
                <img src="../asset/img/logo-gem.png" alt="">
            </div>
        </div>

        <div class="right">
            <div class="logo-mobile">
                <img src="../asset/img/logo-gem.png" alt="">
            </div>

            <div class="box-login">
                <div class="register-button"><a href="https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=1657201123&redirect_uri=https://thavorn-jewelry.com/register/register.php?type_regis=<?=$type_regis?>&state=12345abcde&scope=profile%20openid&nonce=09876xyz">สมัครที่นี่</a></div>

                <p>หรือ</p>

                <h1>เข้าสู่ระบบ</h1>

                <div class="group-form">
                    <div class="row between">
                        <div class="group-input half">
                            <label for="">เบอร์โทรศัพท์</label>
                            <input type="tel" id="phone">
                        </div>

                        <div class="group-input half">
                            <label for="">เลขบัตรประชาชน</label>
                            <input type="password" id="id_no">
                        </div>
                    </div>

                    <div class="button"><button onclick="login()">เข้าสู่ระบบ</button></div>

                    <div class="pdpa"><a href="privacy-policy.php" target="_blank">นโยบายความเป็นส่วนตัว</a></div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="js/register.js"></script>
</body>
</html>