<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PO THAVORN MANAGEMENT</title>

    <style>
        .invoice{
            width: 100%;
        }

        .text-invoice{
            position: absolute;
            font-size: 10px;
        }

        .pos1{
            top: 3%;
            right: 12%;
        }
        .pos2{
            top: 3%;
            left: 19%;
        }
        .pos3{
            top: 17%;
            left: 23%;
        }
        .pos4{
            top: 17%;
            right: 10%;
        }
        .pos5{
            top: 19.4%;
            left: 13%;
        }
        .pos6{
            top: 19.4%;
            right: 10%;
        }
        .pos7{
            top: 31%;
            right: 10%;
            width: 32%;
            height: 200px;
        }
        .pos8{
            top: 25.4%;
            right: 35%;
        }
        .pos9{
            top: 25.4%;
            right: 15%;
        }
        .pos10{
            top: 50.6%;
            left: 11%;
        }
        .pos11{
            top: 50.6%;
            left: 25%;
        }
        .pos12{
            position: absolute;
            top: 25.5%;
            left: 8.7%;
            width: 330px;
            height: 220px;
            object-fit: cover;
        }
        .pos13{
            bottom: 30.6%;
            right: 10%;
        }
        .pos14{
            bottom: 30.6%;
            left: 16%;
        }
        .pos15{
            bottom: 21.3%;
            left: 20%;
        }
        .pos16{
            bottom: 21.3%;
            left: 60%;
        }
        .pos17{
            bottom: 18.6%;
            right: 15%;
        }
        .pos18{
            bottom: 21.3%;
            right: 10%;
        }
        .pos19{
            bottom: 16%;
            left: 9%;
            width: 40%;
        }
        .pos20{
            bottom: 8%;
            left: 10%;
        }
        .pos21{
            bottom: 8%;
            left: 23%;
        }
    </style>
</head>
<body>

    <img class="invoice" id="img_invoice" src="../../asset/img/po.png" alt="">

    <p class="text-invoice pos1"><?php echo $_POST['po_no_form']; ?></p>
    <p class="text-invoice pos2"><?php echo $_POST['datetime_form']; ?></p>
    <p class="text-invoice pos3"><?php echo $_POST['cus_name_form']; ?></p>
    <p class="text-invoice pos4"><?php echo $_POST['id_no_form']; ?></p>
    <p class="text-invoice pos5"><?php echo $_POST['address_form']; ?></p>
    <p class="text-invoice pos6"><?php echo $_POST['phone_form']; ?></p>
    <p class="text-invoice pos7"><?php echo $_POST['detail_form']; ?></p>
    <p class="text-invoice pos8"><?php echo $_POST['price_buy_form']; ?></p>
    <p class="text-invoice pos9"><?php echo $_POST['price_sell_form']; ?></p>
    <p class="text-invoice pos10"><?php echo $_POST['price_buy_num_form']; ?></p>
    <p class="text-invoice pos11"><?php echo $_POST['price_buy_txt_form']; ?></p>
    <img class="pos12" src="<?php echo $_POST['picture_form']; ?>" alt="">
    <p class="text-invoice pos13"><?php echo $_POST['po_no_form']; ?></p>
    <p class="text-invoice pos14"><?php echo $_POST['datetime_form']; ?></p>
    <p class="text-invoice pos15"><?php echo $_POST['cus_name_form']; ?></p>
    <p class="text-invoice pos16"><?php echo $_POST['id_no_form']; ?></p>
    <p class="text-invoice pos17"><?php echo $_POST['address_form']; ?></p>
    <p class="text-invoice pos18"><?php echo $_POST['phone_form']; ?></p>
    <p class="text-invoice pos19"><?php echo $_POST['detail_form']; ?></p>
    <p class="text-invoice pos20"><?php echo $_POST['price_buy_num_form']; ?></p>
    <p class="text-invoice pos21"><?php echo $_POST['price_buy_txt_form']; ?></p>


    <script>
        window.print()
    </script>
</body>
</html>