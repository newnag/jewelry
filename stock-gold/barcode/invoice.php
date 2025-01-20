<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INVOICE THAVORN MANAGEMENT</title>

    <style>
        .invoice{
            width: 100%;
        }

        .text-invoice{
            position: absolute;
            font-size: 10px;
        }

        .pos1{
            top: 10.5%;
            left: 15%;
        }
        .pos2{
            top: 21%;
            left: 15%;
        }
        .pos3{
            top: 13%;
            left: 22%;
        }
        .pos4{
            top: 23%;
            left: 15%;
        }
        .pos5{
            top: 12.8%;
            right: 13%;
        }
        .pos6{
            top: 16.3%;
            right: 8%;
        }
        .pos7{
            top: 31.3%;
            left: 15%;
        }
        .pos8{
            top: 31.3%;
            left: 46%;
        }
        .pos9{
            top: 46.5%;
            right: 10%;
        }
        .pos10{
            top: 49%;
            right: 10%;
        }
        .pos11{
            top: 51.2%;
            right: 10%;
        }
        .pos12{
            top: 53.5%;
            right: 10%;
        }
        .pos13{
            top: 56%;
            right: 10%;
        }
        .pos14{
            top: 58.5%;
            right: 10%;
        }
        .pos15{
            top: 18.5%;
            right: 8%;
        }
        .pos16{
            top: 31.3%;
            left: 5%;
        }
        .pos17{
            top: 31.3%;
            left: 55%;
        }
        .pos18{
            top: 31.3%;
            left: 65%;
        }
        .pos19{
            top: 31.3%;
            left: 75%;
        }
        .pos20{
            top: 31.3%;
            left: 89%;
        }
        .pos21{
            top: 43.5%;
            left: 84%;
        }
        .pos22{
            top: 23.4%;
            right: 8%;
        }
        .pos23{
            top: 21%;
            right: 8%;
        }
        .pos24{
            top: 15%;
            left: 15%;
        }
        .pos25{
            top: 43.5%;
            left: 15%;
        }
    </style>
</head>
<body>
    <?php
        function Convert($amount_number){
            $amount_number = number_format($amount_number, 2, ".","");
            $pt = strpos($amount_number , ".");
            $number = $fraction = "";
            if ($pt === false) 
                $number = $amount_number;
            else
            {
                $number = substr($amount_number, 0, $pt);
                $fraction = substr($amount_number, $pt + 1);
            }
            
            $ret = "";
            $baht = ReadNumber ($number);
            if ($baht != "")
                $ret .= $baht . "บาท";
            
            $satang = ReadNumber($fraction);
            if ($satang != "")
                $ret .=  $satang . "สตางค์";
            else 
                $ret .= "ถ้วน";
            return $ret;
        }
         
        function ReadNumber($number){
            $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
            $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
            $number = $number + 0;
            $ret = "";
            if ($number == 0) return $ret;
            if ($number > 1000000)
            {
                $ret .= ReadNumber(intval($number / 1000000)) . "ล้าน";
                $number = intval(fmod($number, 1000000));
            }
            
            $divider = 100000;
            $pos = 0;
            while($number > 0)
            {
                $d = intval($number / $divider);
                $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" : 
                    ((($divider == 10) && ($d == 1)) ? "" :
                    ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
                $ret .= ($d ? $position_call[$pos] : "");
                $number = $number % $divider;
                $divider = $divider / 10;
                $pos++;
            }
            return $ret;
        }

        $str_number = Convert($_POST['net_vat_invoice']);
    ?>

    <img class="invoice" id="img_invoice" src="../../asset/img/invoice.png" alt="">

    <p class="text-invoice pos1"><?php echo $_POST['cus_id_invoice']; ?></p>
    <p class="text-invoice pos2"><?php echo $_POST['cus_name_invoice']; ?></p>
    <p class="text-invoice pos3"><?php echo $_POST['cus_idcard_invoice']; ?></p>
    <p class="text-invoice pos4"><?php echo $_POST['address_invoice']; ?></p>
    <p class="text-invoice pos5"><?php echo $_POST['date_invoice']; ?></p>
    <p class="text-invoice pos6"><?php echo $_POST['gold_price_invoice']; ?></p>
    <p class="text-invoice pos7"><?php echo $_POST['item_name_invoice']; ?></p>
    <p class="text-invoice pos8"><?php echo $_POST['item_weight_invoice']; ?> กรัม</p>
    <p class="text-invoice pos9"><?php echo number_format($_POST['net_vat_invoice'],2); ?></p>
    <p class="text-invoice pos10"><?php echo number_format($_POST['resale_invoice'],2); ?></p>
    <p class="text-invoice pos11"><?php echo number_format($_POST['diff_invoice'],2); ?></p>
    <p class="text-invoice pos12"><?php echo number_format($_POST['vat_base_invoice'],2); ?></p>
    <p class="text-invoice pos13"><?php echo number_format($_POST['vat_invoice'],2); ?></p>
    <p class="text-invoice pos14"><?php echo number_format($_POST['vat_exclude_invoice'],2); ?></p>
    <p class="text-invoice pos15"><?php echo $_POST['gold_sale_price'] ?></p>
    <p class="text-invoice pos16 c-no">1</p>
    <p class="text-invoice pos17 c-unit">กรัม</p>
    <p class="text-invoice pos18 c-qty">1</p>
    <p class="text-invoice pos19 c-u-price"><?php echo number_format($_POST['net_vat_invoice'],2); ?></p>
    <p class="text-invoice pos20 c-amount"><?php echo number_format($_POST['net_vat_invoice'],2); ?></p>
    <p class="text-invoice pos21 c-total"><?php echo number_format($_POST['net_vat_invoice'],2); ?> บาท</p>
    <p class="text-invoice pos22"><?php echo number_format($_POST['invoice_sell_per_gram'],2); ?></p>
    <p class="text-invoice pos23"><?php echo $_POST['gold_sale_price_racket'] ?></p>
    <p class="text-invoice pos24">สำนักงานใหญ่</p>
    <p class="text-invoice pos25"><?=$str_number?></p>

    <script>
        window.print()
    </script>
</body>
</html>