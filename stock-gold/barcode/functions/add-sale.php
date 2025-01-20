<?php

include('../../../config/db.php');
include('../../../classes/sale-gold.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "barcode" => "",
  "cus_id" => $_POST['cus_id'],
  "item_id" => $_POST['item_id'],
  "date_sale" => $_POST['date_sale'],
  "gold_price" => $_POST['gold_price'],
  "wage" => $_POST['wage'],
  "sum_sale" => $_POST['sum_sale'],
  "net_vat" => $_POST['net_vat'],
  "resale_price" => $_POST['resale_price'],
  "diff" => $_POST['diff'],
  "vat_base" => $_POST['vat_base'],
  "vat" => $_POST['vat'],
  "price_exclude" => $_POST['price_exclude']
);

$sale = new Sale_gold($data);
$add_sale = $sale->add_sale($_POST['point'],$_POST['resale_price']);

if($add_sale){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}