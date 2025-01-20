<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../function/check-login.php');
include('../../classes/stock-jewelry-product.php') ;
include('../../classes/user.php');

check_login($conn);
?>

<?php
// query data
$data = array(
    "conn" => $conn,
    "type_build" => "",
    "stock_date" => "",
    "type_product" => "",
    "product_no" => "",
    "detail" => "",
    "size" => "",
    "weight" => "",
    "cost" => "",
    "cost_id" => "",
    "price_sale" => "",
    "price_id" => "",
    "sale_date" => "",
    "status_product" => "",
    "reuse_product" => "",
    "reuse_detail" => "",
    "id" => $_GET['id']
);

$stock = new Stock_jewelry_product($data);
$get_data = $stock->get_data_waranty();
$get_pic = $stock->get_pic_product($get_data['id']);
$pic_warranty = $get_pic['path_1'];
$predate_product = strtotime($get_data['sale_date']);
$date_product = date('d/m/Y', $predate_product);
$arr_loose = json_decode($get_data['loose_diamond']); // decode data loose to json
$arr_loose_data = array();
foreach ($arr_loose as $key => $value) {
    $arr_loose_data[$key]['amount'] = $value->amount;
    $arr_loose_data[$key]['weight'] = $value->weight;
}

// data user
$data_user = array(
    "conn" => $conn,
    "fullname" => "",
    "sex" => "",
    "dob" => "",
    "phone" => "",
    "address" => "",
    "id_no" => "",
    "line_id" => "",
    "id_file" => "",
    "bookbank" => "",
    "id_customer" => "",
    "id" => $_GET['user_id']
);
$user = new User($data_user);
$get_user = $user->get_data();

// print_r($arr_loose_data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warranty</title>

    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body{
            height: 4in;
            width: 2.6in;
            rotate: 90deg;
            position: absolute;
            top: -38px;
            left: 164px;
            font-size: 0.5em;
        }

        .logo{
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 145px;
            margin-bottom: 10px;
        }
        .logo figure, .logo figure img{
            height: 100%;
        }

        .product_pic{
            width: 100%;
            height: 150px;
            border-bottom: 1px solid #1d3d6c;
            padding-bottom: 10px;
            text-align: center;
        }
        .product_pic figure,.product_pic figure img{
            height: 100%;
        }

        .detail{
            margin: 5px 0;
            border-bottom: 1px solid #1d3d6c;
        }

        .customer{
            margin: 5px 0;
        }

        .ps{
            margin: 10px 0;
            background: #1d3d6c;
            color: #fff;
            text-align: center;
            padding: 5px;
            font-size: .70em;
        }

        .row{
            display: flex;
            margin-bottom: 5px;
        }
        .row.p-detail{
            height: 3em;
        }
        .row.p-detail .col-1{
            align-items: flex-start;
        }
        .col-1{
            width: 100%;
            display: flex;
            align-items: center;
        }
        .col-2{
            width: calc(100%/2);
            display: flex;
            align-items: center;
        }
        .col-3{
            width: calc(100%/3);
            display: flex;
            align-items: center;
        }

        .txt{
            margin-left: 5px;
            text-decoration: underline;
        }
        .product-no{
            font-size: 1.5em;
            color: #1d3d6c;
        }
        .price{
            font-size: 1.25em;
        }
    </style>
</head>
<body>

    <div class="logo"><figure><img src="../../asset/img/logo.png" alt=""></figure></div>

    <div class="product_pic">
        <figure><img src="https://thavorn-jewelry.com/uploads/stock-jewelry/<?=$pic_warranty?>" alt=""></figure>
    </div>

    <div class="detail">
        <div class="row">
            <div class="col-3">
                <p class="product-no">No.F-1027</p>
            </div>
            <div class="col-3">
                <label for="">DATE : </label>
                <p class="txt"> <?=$date_product?></p>
            </div>
            <div class="col-3">
                <label for="">CODE : </label>
                <p class="txt"> <?=$get_data['product_no']?></p>
            </div>
        </div>

        <div class="row">
            <div class="col-1">
                <label for="">INFO : </label>
                <p class="txt"><?=$get_data['product_name']?></p>
            </div>
        </div>

        <div class="row p-detail">
            <div class="col-1">
                <label for="" style="width:25px">Detail : </label>
                <p class="txt">
                    <?php 
                        foreach ($arr_loose_data as $key => $value) {
                            echo "RD".$value['amount']."=".$value['weight']."ct " ; // เพชร
                        }
                        echo " ".$get_data['type_material'].".".$get_data['percent_gold'].".".$get_data['gold'].".".$get_data['gold_weight'] ; // ตัวเรือน
                    ?>
                </p>
            </div>
        </div>

        <?php
            $price = $_GET['price'];
            setlocale(LC_MONETARY,"en_US");
            $price = number_format($price,2);
        ?>

        <div class="row">
            <div class="col-2">
                <label for="">PRICE : </label>
                <p class="txt price"><?=$price?> .-</p>
            </div>
        </div>
    </div>
    
    <div class="customer">
        <div class="row">
            <div class="col-2">
                <label for="">NAME : </label>
                <p class="txt"><?=$get_user[0]['fullname']?></p>
            </div>

            <div class="col-2">
                <label for="">MOBILE : </label>
                <p class="txt"><?=$get_user[0]['phone']?></p>
            </div>
        </div>
    </div>

    <div class="ps">
        <p>สินค้าเปลี่ยนหัก 15% ขายคืนหัก 20% ตามสภาพ</p>
        <p>ขอสงวนสิทธิ์ในการเปลี่ยนแปลงเงื่อนไขโดยที่ทางร้านไม่ต้องแจ้งให้ทราบล่วงหน้า</p>
    </div>

    <script>
        const printing = setTimeout(function(){
            window.print()
        },300)
    </script>
</body>
</html>

