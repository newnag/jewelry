<?php

include('../../../config/db.php');
include('../../../classes/buying-gold.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "po_no" => "",
  "cus_id" => "",
  "datetime" => "",
  "type_product" => "",
  "amount" => "",
  "weight" => "",
  "detail" => "",
  "price_buy" => "",
  "price_sell" => "",
  "price_buy_num" => "",
  "price_buy_txt" => "",
  "customFile" => "",
  "id" => ""
);

$sale = new Buy_gold($data);
$get_sale = $sale->upload_file($_FILES['img']);

if($get_sale){
  http_response_code(200);
  echo $get_sale;
}
else{
  http_response_code(404);
  echo "error";
}