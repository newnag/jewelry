<?php

include('../../../config/db.php');
include('../../../classes/buying-gold.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "cus_id" => $_POST['cus_id'],
  "po_no" => $_POST['po_no'],
  "datetime" => $_POST['datetime'],
  "type_product" => $_POST['type_product'],
  "amount" => $_POST['amount'],
  "weight" => $_POST['weight'],
  "detail" => $_POST['detail'],
  "price_buy" => $_POST['price_buy'],
  "price_sell" => $_POST['price_sell'],
  "price_buy_num" => $_POST['price_buy_num'],
  "price_buy_txt" => $_POST['price_buy_txt'],
  "customFile" => $_FILES['customFile']
);

$sale = new Buy_gold($data);
$add_sale = $sale->add_buy();

if($add_sale){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}