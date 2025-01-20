<?php

include "../../plugins/barcode-gen/BarcodeGenerator.php";
include "../../plugins/barcode-gen/BarcodeGeneratorPNG.php";

$code = $_GET['barcode'];//รหัส Barcode ที่ต้องการสร้าง
header('Content-Type: image/png');
$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
$border = 2;//กำหนดความหน้าของเส้น Barcode
$height = 50;//กำหนดความสูงของ Barcode

echo $generator->getBarcode($code , $generator::TYPE_CODE_128,2,30,array(0,0,0));
echo $code ;

echo "<hr>";
  
?>