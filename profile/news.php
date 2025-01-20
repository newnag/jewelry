<?php
    include('../config/db.php');
    include('../classes/user.php');
    include('functions/check-login.php');

    check_login($conn);

    // get user data
    $data = array(
        "conn" => $conn,
        "fullname" => "",
        "sex" => "",
        "dob" => "",
        "phone" => "",
        "address" => "",
        "id_no" => "",
        "line_id" => "",
        "email" => "",
        "id_file" => "",
        "bookbank" => "",
        "id_customer" => "",
        "id" => $_SESSION['user_id']
    );

    $user = new User($data);
    $get_data = $user->get_data_profile();

    $raw_date =  explode("-",$get_data['DOB']);
    $con_year = intval($raw_date[0])+543;
    $dob = $raw_date[2]."/".$raw_date[1]."/".$con_year;

    $code = $_GET['code'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="expires" content="0">
    <title>Thavorn Jewelry</title>

    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/profile.min.css">
</head>
<body>
    <input type="hidden" id="code" value="<?=$code?>">

    <div class="header">
        <div class="logo"><img src="../asset/img/logo-gem.png" alt=""></div>
        <div class="logo"><img src="../asset/img/logo-gold.png" alt=""></div>
    </div>

    <div class="content">
        <div class="article">
            <pre>
            ทุกๆยอดค่ากำเหน็ด 50 บาท ได้รับ 1 คะแนน 

            วิธีสะสมแต้มคะแนน
            1. สมัครสมาชิกรับเลยธูปนำโชคไอ้ไข่ และ คะแนน 10 แต้ม
            2. สมาชิกรับส่วนลดจากค่ากำเหน็ด 10 %
            3. สำหรับวันเกิดรับส่วนลดค่ากำเหน็ด 20 % และรับคะแนนสะสมเพิ่มเป็น 2 เท่า
            
            แต้มคะแนนและของรางวัล
            20 แต้ม แลกรับ กระติ๊กน้ำ
            35 แต้ม แลกรับ ร่ม
            50 แต้ม แลกรับ กระเป๋า
            100 แต้ม แลกรับบัตรเติมน้ำมัน
            </pre>
        </div>

        <div class="group-button">
            <a href="index.php" class="btn blue">หน้าแรก</a>
            <a href="edit-profile.php?id=<?=$data['id']?>" class="btn blue">แก้ไขประวัติ</a>
            <a href="" class="btn blue">แจ้งโอนต่อดอก</a>
            <a href="news.php" class="btn blue">ข่าวสาร/โปรโมชั่น</a>
            <a href="tel:043225579" class="btn yellow">โทรติดต่อ</a>
            <button class="btn red" onclick="logout()">ออกจากระบบ</button>
        </div>
    </div>

    <div class="footer"><p>Copyright 2022 <a href="">Thavorn Jewelry</a></p></div>


    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="js/profile.js"></script>
</body>
</html>