<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QRCode Generator</title>

    <style>
        .box-price{
            display: inline-block;
            width: 3cm;
            height: 2cm;
            position: relative;
        }
        .tag-price{
            width: 3cm;
            height: 2cm;
        }
        .qrcode-img{
            position: absolute;
            width: 49px;
            height: 49px;
            z-index: 1;
            top: 3px;
            left: 4px;
        }
        .txt{
            position: absolute;
            font-size: 0.35rem;
            z-index: 1;
            top: 46px;
            left: 5px;
        }
        .txt_type{
            position: absolute;
            font-size: 0.35rem;
            z-index: 1;
            top: 57px;
            left: 5px;
        }
        .txt_weight{
            position: absolute;
            font-size: 0.35rem;
            z-index: 1;
            top: 23px;
            left: 77px;
        }
        .txt_size{
            position: absolute;
            font-size: 0.35rem;
            z-index: 1;
            top: 36px;
            left: 82px;
        }
        .txt_wage{
            position: absolute;
            font-size: 0.35rem;
            z-index: 1;
            top: 53px;
            left: 74px;
        }
    </style>
</head>
<body>
<?php
    $code_item =array();
    $decode_data = json_decode($_POST['data'][0]);

    foreach($decode_data as $data){
        $code_item[] = $data;
    }

    for($i=0;$i<count($code_item);$i++){
        // echo '
        //     <img src="https://thavorn-jewelry.com/asset/img/price-tag.png" class="tag-price" />
        //     <img src="https://chart.googleapis.com/chart?chs=50x50&cht=qr&chl='.$code_item[$i].'&chld=L|1&choe=UTF-8" title="" class="qrcode-img img'.$i.'" />
        //     <p class="txt product_no_'.$i.'">'.$code_item[$i].'</p>
        // ';

        echo '
            <div class="box-price">
                <img src="https://thavorn-jewelry.com/asset/img/price-tag.png" class="tag-price" />
                <img src="https://chart.googleapis.com/chart?chs=50x50&cht=qr&chl='.$code_item[$i]->product_no.'&chld=L|1&choe=UTF-8" title="" class="qrcode-img" />
                <p class="txt product_no_'.$i.'">'.$code_item[$i]->product_no.'</p>
                <p class="txt_type">'.$code_item[$i]->type.'</p>
                <p class="txt_weight">'.$code_item[$i]->weight.' กรัม</p>
                <p class="txt_size">'.$code_item[$i]->size.'</p>
                <p class="txt_wage">'.$code_item[$i]->wage.'-</p>
            </div>
        ';
    } 
?>

</body>
</html>
