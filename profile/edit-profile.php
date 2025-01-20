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

    // print_r($get_data);

    $raw_date =  explode("-",$get_data[0]['DOB']);
    // $con_year = intval($raw_date[0])+543;
    $dob = $raw_date[2]."/".$raw_date[1]."/".$raw_date[0];
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
</head>
<body>
    <input type="hidden" id="user_id" value="<?=$get_data[0]['id']?>">

    <div class="header">
        <div class="logo"><img src="../asset/img/logo-gem.png" alt=""></div>
        <div class="logo"><img src="../asset/img/logo-gold.png" alt=""></div>
    </div>

    <div class="content edit">
        <div class="edit-profile">
            <h1>แก้ไขข้อมูลสมาชิก</h1>

            <div class="box-text">
                <p>รหัสสมาชิก</p>
                <input type="text" class="input-box" id="" value="<?=$get_data[0]['id_customer']?>" disabled>
            </div>
            <div class="box-text">
                <p >ชื่อ-สกุล</p>
                <input type="text" class="input-box" id="name" value="<?=$get_data[0]['fullname']?>">
            </div>
            <div class="box-text">
                <p >เพศ</p>
                <select name="" id="sex" class="input-box">
                    <?php
                        if($get_data[0]['sex'] != ""){
                            $sex = $get_data[0]['sex'];
                            switch ($sex) {
                              case 'ชาย':
                                echo '
                                <option value="ชาย" selected>ชาย</option>
                                <option value="หญิง">หญิง</option>
                                ';
                                break;
                              
                              case 'หญิง':
                                echo '
                                <option value="หญิง" selected>หญิง</option>
                                <option value="ชาย">ชาย</option>
                                ';
                                break;
                            }
                        }
                        else{
                        echo '<option value="ชาย" selected>ชาย</option>
                        <option value="หญิง">หญิง</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="box-text">
                <p >วันเกิด</p>
                <input type="text" class="input-box" id="dob" value="<?=$dob?>">
            </div>
            <div class="box-text">
                <p >เบอร์โทรศัพท์</p>
                <input type="text" class="input-box" id="" value="<?=$get_data[0]['phone']?>" disabled>
            </div>
            <div class="box-text">
                <p>ที่อยู่</p>
                <textarea name="" id="address" class="textarea" cols="30" rows="2"><?=$get_data[0]['address']?></textarea>
            </div>
            <div class="box-text">
                <p >เลขบัตรประชาชน</p>
                <input type="text" class="input-box" id="" value="<?=$get_data[0]['id_no']?>" disabled>
            </div>
            <div class="box-text">
                <p >Line ID</p>
                <input type="text" class="input-box" id="line_id" value="<?=$get_data[0]['line_id']?>">
            </div>
            <div class="box-text">
                <p >อีเมล์</p>
                <input type="text" class="input-box" id="email" value="<?=$get_data[0]['email']?>">
            </div>

            <div class="submit-button">
                <button class="btn success" onclick="update()">แก้ไข</button>
                <button class="btn primary" onclick="back()">กลับ</button>
            </div>
        </div>

        <!-- Zone picture -->
        <?php
            if(isset($get_data[0]['file'])){
                if($get_data[0]['file']['id_path'] != ""){
                    $id_path =  "อัพโหลดภาพเรียบร้อยแล้ว";
                }
                else{
                    $id_path = "ยังไม่ได้อัพโหลดภาพ";
                }

                if($get_data[0]['file']['bookbank_path'] != ""){
                    $bookbank =  "อัพโหลดภาพเรียบร้อยแล้ว";
                }
                else{
                    $bookbank = "ยังไม่ได้อัพโหลดภาพ";
                }
            }
        ?>

        <div class="upload-file">
            <div class="box">
                <p>ภาพบัตรประชาชน</p>
                <input type="text" class="filename" id="filename1" value="<?=$id_path?>" readonly>
                <div class="button">
                    <button class="selector" onclick="select_pic(1)">เลือกรูปภาพ</button>
                    <button class="upload" onclick="upload_file(1)">อัพโหลด</button>
                    <input type="file" id="file1" style="display:none">
                </div>
            </div>

            <div class="box">
                <p>ภาพสมุดบัญชีธนาคาร</p>
                <input type="text" class="filename" id="filename2" value="<?=$bookbank?>" readonly>
                <div class="button">
                    <button class="selector" onclick="select_pic(2)">เลือกรูปภาพ</button>
                    <button class="upload" onclick="upload_file(2)">อัพโหลด</button>
                    <input type="file" id="file2" style="display:none">
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