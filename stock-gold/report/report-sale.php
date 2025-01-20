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

// $raw_data = json_decode($_POST['report_item_id']);

$sql = new Report_gold($data);
$query = $sql->report_sale($_GET['month']);

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

    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/plugins/jquery-ui/jquery-ui.min.css">

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

    <p class="head-txt">รายงานภาษีมูลค่าเพิ่ม</p>
    <p class="head-txt">รายงานภาษีขาย</p>

    <div class="grid">
        <div class="row-head">
            <p>ชื่อผู้ประกอบการ สำนักงานใหญ่</p>
            <p>สำหรับเดือน <?=$now_month?> <?=$now_year?></p>
        </div>

        <div class="row-head">
            <p>ชื่อสถานประกอบการ บริษัท ทองถาวร (เองฮุยฮึ้ง) จำกัด</p>
            <p>ลำดับเลขที่สาขา 0000</p>
        </div>
    </div>


    <table id="table-report" class="table table-bordered table-hover" style="font-size:0.5em">
        <thead>
            <tr>
                <th>วันเดือนปี</th>
                <th>เลขใบกำกับภาษี</th>
                <th>ลูกค้า</th>
                <th>เลขประจำตัวผู้เสียภาษี</th>
                <th>น้ำหนัก</th>
                <th>หน่วย</th>
                <th>ยอดขายรวมภาษีมูลค่าเพิ่ม</th>
                <th>ผลต่างรวมภาษีมูลค่าเพิ่ม</th>
                <th>ฐานภาษีมูลค่าเพิ่ม</th>
                <th>ภาษีมูลค่าเพิ่ม</th>
                <th>ยอดขายที่ไม่รวมภาษีมูลค่าเพิ่ม</th>
            </tr>
        </thead>

        <tbody>
            <?php
                if($query != "" || $query != null){
                    for($i=0;$i<count($query);$i++){

                        $raw_date = explode(" ",$query[$i]['create_date']);
                        $raw_date_format = explode("-",$raw_date[0]);
                        $cur_date = $raw_date_format[2]."/".$raw_date_format[1]."/".$raw_date_format[0];

                    //////////////////////////////////////////////////////////////////////////////////////////

                        echo "
                            <tr>
                                <td>".$cur_date.". ".$raw_date[1]."</td>
                                <td>TR".$now_year_mini.$nowmonth_mini."-</td>
                                <td>".$query[$i]['fullname']."</td>
                                <td>".$query[$i]['id_no']."</td>
                                <td>".$query[$i]['weight']."</td>
                                <td>กรัม</td>
                                <td>".$query[$i]['net_total']."</td>
                                <td>".$query[$i]['diff_sell_price']."</td>
                                <td>".$query[$i]['vat_base']."</td>
                                <td>".$query[$i]['vat']."</td>
                                <td>".$query[$i]['vat_exclude']."</td>
                            </tr>
                        ";
                    }
                }
            ?>
        </tbody>
    </table>

    <script>
        const printing = setTimeout(function(){
            window.print()
        },300)
    </script>
</body>
</html>