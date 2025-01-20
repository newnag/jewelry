<?php 

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../function/check-login.php');
include('../../classes/report-jewelry.php') ;

check_login($conn);
?>


<?php
$data = array(
    "conn" => $conn
);

///////////////////////////////////////////////
// query zone
///////////////////////////////////////////////

$sql = new Report_jewelry($data);
$query = $sql->get_body();
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
    </style>
</head>
<body>

    <?php 
        // $doc = '
        //     <table id="table-report" class="table table-bordered table-hover">
        //         <thead class="head-table" style="background: #003366;color:#fff;">
        //             <tr>
        //                 <th>supplier</th>
        //                 <th style="width: 33%">รูป</th>
        //                 <th>ประเภทโลหะ</th>
        //                 <th>น้ำหนัก</th>
        //                 <th>เปอร์เซ็น</th>
        //             </tr>
        //         </thead>';

        // $doc .= '<tbody>';
                    
        // if($query != "" || $query != null){
        //     for($i=0;$i<count($query);$i++){

        //     $get_pic = $sql->get_pic($query[$i]['id']);

        //     $doc .= '
        //         <tr>
        //             <td>'.$query[$i]["supplier"].'</td>
        //             <td class="thumbnail" style="width:200px;height:200px;"><img style="width:100%;height:100%;" src="https://thavorn-jewelry.com/uploads/stock-body/'.$get_pic['path'].'"></td>
        //             <td>'.$query[$i]["type_material"].'</td>
        //             <td>'.$query[$i]["weight"].'</td>
        //             <td>'.$query[$i]["percent_gold"].'</td>
        //         </tr>
        //     ';
        //     }
        // }
                    
        // $doc .=' </tbody>
        //     </table>
        // ';

        //////////////////////////////////////////////////////////////////////////////

        // require_once('../../vendor/autoload.php');

        // $mpdf = new mPDF();
        // $mpdf->WriteHTML($doc);
        // $mpdf->Output();
    ?>

    <table id="table-report" class="table table-bordered table-hover">
        <thead class="head-table">
            <tr>
                <th>supplier</th>
                <th>รูป</th>
                <th>ประเภทโลหะ</th>
                <th>น้ำหนัก</th>
                <th>เปอร์เซ็น</th>
            </tr>
        </thead>

        <tbody>
            <?php
                if($query != "" || $query != null){
                    for($i=0;$i<count($query);$i++){

                    $get_pic = $sql->get_body_pic($query[$i]['id']);

                    echo "
                        <tr>
                            <td>".$query[$i]['supplier']."</td>
                            <td class='thumbnail'><img src='https://thavorn-jewelry.com/uploads/stock-body/".$get_pic['path']."'></td>
                            <td>".$query[$i]['type_material']."</td>
                            <td>".$query[$i]['weight']."</td>
                            <td>".$query[$i]['percent_gold']."</td>
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

