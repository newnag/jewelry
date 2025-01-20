<?php

include('../../../config/db.php');
include('../../../classes/sale-gold.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "barcode" => $_POST['barcode'],
  "cus_id" => "",
  "item_id" => "",
  "sale_date" => "",
  "price_id" => "",
  "price" => "",
);

  $sale = new Sale_gold($data);
  $get_sale = $sale->get_table();

if($get_sale){
  http_response_code(200);
  echo json_encode($get_sale);
}
else{
  http_response_code(404);
  echo "error";
}