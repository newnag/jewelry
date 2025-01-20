<?php 

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../function/check-login.php');
include('../../classes/report-gold.php') ;

check_login($conn);
?>


<?php

$data = array(
    "conn" => $conn,
    "date1" => "",
    "date2" => "",
    "type_report" => ""
);

///////////////////////////////////////////////
// query zone
///////////////////////////////////////////////

// current month thai
$month_thai = array(
    "", 
    "มกราคม", 
    "กุมภาพันธ์", 
    "มีนาคม",
    "เมษายน",
    "พฤษภาคม",
    "มิถุนายน",
    "กรกฎาคม",
    "สิงหาคม",
    "กันยายน",
    "ตุลาคม",
    "พฤศจิกายน",
    "ธันวาคม"
);
$now_year = date('Y');
$now_year_mini = date('y');
$now_date = date('n');
$now_month = $month_thai[$now_date];
$nowmonth_mini = date('m');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <script src="../../plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../plugins/jquery-ui/jquery-ui.min.css">  

    <style>
        @page {
            size: landscape;
        }
        .thumbnail{
            width:200px;
            height:200px;
        }
        .thumbnail img{
            width:100%;
            height:100%;
        }

        .head-table{
            background: #003366;
            color:#fff;
        }

        h2{
            text-align: center;
            font-size: 1.8em
        }
        .head-txt{
            text-align: center;
            font-size: 1.6em
        }
        .grid{
            display: grid;
            grid-template-rows: repeat(2,50%);
            padding: 0 4em;
        }
        .grid .row-head{
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body> 
    <h2>บริษัท ทองถาวร (เองฮุยฮึ้ง) จำกัด(สำนักงานใหญ่)</h2>
    <h2>เลขที่ 156 ถนนศรีจันทร์ ต.ในเมือง อ.เมืองขอนแก่น ขอนแก่น 40000</h2>
    <h2>เลขประจำตัวผู้เสียภาษี 0405559004118 โทร 043221545</h2>

    <!-- <p class="head-txt">รายงานภาษีมูลค่าเพิ่ม</p>
    <p class="head-txt">รายงานภาษีซื้อ</p> -->
    <br>
    <p class="head-txt">สมุดบัญชีซื้อทอง / สุดบัญชีจ่าย</p>
    <br><br>
    <!-- <div class="grid">
        <div class="row-head">
            <p>ชื่อผู้ประกอบการ สำนักงานใหญ่</p>
            <p>สำหรับเดือน <?=$now_month?> <?=$now_year?></p>
        </div>

        <div class="row-head">
            <p>ชื่อสถานประกอบการ บริษัท ทองถาวร (เองฮุยฮึ้ง) จำกัด</p>
            <p>ลำดับเลขที่สาขา 0000</p>
        </div>
    </div> -->

    <?php
        // รับ result มาจาก report.js ใน print_buy_report()
        $result = json_decode($_GET['result'], true);
        // print_r($result);
  
        // if (isset($_GET['show_swal']) && $_GET['show_swal'] == 'true') {
        // echo '
        //     <script>
        //     Swal.fire({
        //         icon: "success",
        //         title: "สำเร็จ!",
                
        //     });
        //     </script>
        // ';
        // }
        
    ?>
    <div class="col-11 container-fluid">
        <table id="table-report" class="table table-bordered table-hover">
            <thead class="text-center">
                <tr>
                    <th>วันเดือนปี</th>
                    <th>เลขใบสำคัญรับเงิน</th>
                    <th>ผู้ขาย</th>
                    <th>เลขประจำตัวผู้เสียภาษี</th>
                    <th>รายการ</th>
                    <th>น้ำหนัก</th>
                    <th>จำนวนเงิน (บาท)</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    if($result != "" || $result != null){
                        $sum_weight = 0;
                        $sum_cost_price = 0;
                        for($i=0;$i<count($result);$i++){
                            $raw_date = explode(" ",$result[$i]['create_date']);
                            $raw_date_format = explode("-",$raw_date[0]);
                            $cur_date = $raw_date_format[2]."/".$raw_date_format[1]."/".$raw_date_format[0];

                            $cost_price = str_replace(",", "", $result[$i]['cost_price']);
                            $sum_cost_price += floatval($cost_price);
                            $sum_weight += $result[$i]['weight'];
                            $sum_cost_price_formatted = number_format($sum_cost_price, 2, '.', ',');
                        //////////////////////////////////////////////////////////////////////////////////////////

                            echo "
                                <tr class='text-center'>
                                    <td>".$cur_date."<br>".$raw_date[1]."</td>
                                    <td style='text-align:center;'>รอค่า</td>
                                    <td class='text-left pt-auto pb-auto'>".$result[$i]['name']."</td>
                                    <td>".$result[$i]['tax_id']."</td>
                                    <td class='text-left'>".$result[$i]['type_name']." ".$result[$i]['cate_name']."</td>
                                    <td class='text-right'>".$result[$i]['weight']." กรัม"."</td>
                                    <td class='text-right'>".$result[$i]['cost_price']."</td>
                                </tr>
                            ";
                        }
                        echo "<tr>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td class='text-center'>รวม</td>";
                        echo "<td class='text-right'>".$sum_weight." กรัม"."</td>";
                        echo "<td class='text-right'>".$sum_cost_price_formatted."</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>              

    <script>
        // const printing = setTimeout(function(){
        //     window.print()
        // },300)
    </script>
</body>
</html>