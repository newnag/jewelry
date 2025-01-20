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
        "id" => $_GET['id']
    );

    $user = new User($data);
    $get_data = $user->get_data();
    $get_item = $user->get_item_rental();

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
    <link rel="stylesheet" href="../plugins/jquery-ui/jquery-ui.min.css">
    <link rel="stylesheet" href="../css/profile.min.css">

    <style>
      .thumbnail{
        width: 100%;
        height: 300px;
        margin-bottom:1em;
      }
      .thumbnail img{
        width: 100%;
        height: 100%;
      }
    </style>
</head>
<body>
    <input type="hidden" id="user_id" value="<?=$get_data[0]['id']?>">

    <div class="header">
        <div class="logo"><img src="../asset/img/logo-gem.png" alt=""></div>
        <div class="logo"><img src="../asset/img/logo-gold.png" alt=""></div>
    </div>

    <div class="content edit">
      <div class="edit-profile">
        <h1>แจ้งโอนสลิป</h1>

        <input type="hidden" id="user_id" value="<?=$get_data[0]['id']?>">

        <div class="box-text">
          <p>เลือกรายการที่ต่อดอก</p>
          <select name="" id="select_item" class="input-box">
            <option value="">เลือกรายการ</option>
            
            <?php
              foreach ($get_item as $key => $value) {
                echo '
                  <option value="'.$value['id'].'">'.$value['product_name'].'</option>
                ';
              }
            ?>
          </select>
        </div>

        <div class="box-text">
          <p>จำนวนเงินที่โอน</p>
          <input type="number" class="input-box" id="interest" value="">
        </div>
        
      </div>
    
      <div class="upload-file">
        <div class="box">
          <p>สลิปโอนเงิน</p>
          <div class="thumbnail"><img src="../../asset/img/default.jpg" alt=""></div>
          <div class="button">
              <button class="selector" onclick="select_slip()">เลือกรูปภาพ</button>
              <button class="upload" onclick="upload_slip()">อัพโหลด</button>
              <input type="file" id="file_slip" style="display:none" onchange="change_pic(event)">
          </div>
        </div>
      </div>
    </div>



    <div class="footer"><p>Copyright 2022 <a href="">Thavorn Jewelry</a></p></div>


    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="js/profile.js"></script>

    <script>
        $(function (){
            $('#dob').datepicker({
                dateFormat : "dd/mm/yy"
            })
        })
    </script>
</body>
</html>