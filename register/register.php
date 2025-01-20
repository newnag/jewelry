<?php
    include('functions/check-login.php');
?>

<?php
    if(isset($_GET['type_regis'])){
        $type_regis = $_GET['type_regis'];
    }
    else{
        $type_regis = 0;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thavorn Jewelry</title>

    <link rel="stylesheet" href="../css/register.min.css?v=1.02">
    <link rel="stylesheet" href="../plugins/jquery-ui/jquery-ui.min.css">
    <!-- <link href="../../plugins/datepicker-thai/css/datepicker.css" rel="stylesheet"> -->
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

            <div class="box-regis">
                <h1>สมัครสมาชิก</h1>

                <input type="hidden" id="type_regis" value="<?=$type_regis?>">

                <div class="group-form-one">
                    <div class="group-input">
                        <label for="">เบอร์โทรศัพท์</label>
                        <input type="tel" id="phone">
                    </div>

                    <div class="group-input">
                        <label for="">รหัสบัตรประชาชน</label>
                        <input type="text" id="id_no">
                    </div>

                    <div class="group-input">
                        <label for="">ชื่อ-สกุล</label>
                        <input type="text" id="fullname">
                    </div>

                    <div class="group-input">
                        <label for="">Line ID</label>
                        <input type="text" id="line_id">
                    </div>

                    <div class="group-input">
                        <label for="">อีเมล์</label>
                        <input type="email" id="email">
                    </div>

                    <div class="group-input">
                        <label for="">ที่อยู่</label>
                        <textarea name="" id="address" cols="30" rows="4"></textarea>
                    </div>

                    <div class="group-input">
                        <label for="">วัน-เดือน-ปี เกิด(พ.ศ.)</label>
                        <input type="text" id="dob" placeholder="dd/mm/yyyy">
                    </div>

                    <?php $code = $_GET['code']; ?>
                    <input type="hidden" id="code" value="<?=$code?>">
                    <input type="hidden" id="line_user" value="">

                    <div class="pdpa">
                        <label for="check_pdpa">ฉันยอมรับ <a href="privacy-policy.php" target="_blank">นโยบายความเป็นส่วนตัว</a></label>
                        <input type="checkbox" id="check_pdpa" name="check_pdpa">
                    </div>

                    <div class="button"><button id="submit_reg" onclick="regis()" disabled>สมัครสมาชิก</button></div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="../../plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- <script src="../../plugins/datepicker-thai/js/jquery-ui-1.8.10.offset.datepicker.min"></script> -->
    <script src="js/register.js"></script>
    <script>
        window.onload = ()=>{
            getLine_user()
        }

        // $('#dob').datepicker({
        //     dateFormat: "dd/mm/yy",
        //     language:'th-th'
        // });

        // check PDPA Read
        document.querySelector('#check_pdpa').addEventListener('change',function(){
            if(this.checked){
                document.querySelector('#submit_reg').disabled = false
            }
            else{
                document.querySelector('#submit_reg').disabled = true
            }
        })

        // var d = new Date();
		// var toDay = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 543);

        // $("#dob").datepicker({ changeMonth: true, changeYear: true,dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay,dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
        //       dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
        //       monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
        //       monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
    </script>
</body>
</html>