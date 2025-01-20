<?php

include('../../../config/db.php');
include('../../../classes/sale-jewelry.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "barcode" => $_POST['item_id'],
  "cus_id" => "",
  "item_id" => $_POST['id'],
  "date_sale" => "",
  "sale_price" => "",
  "sell_price" => "",
  "point_received" => "0",
);

$sale = new Sale_jewelry($data);
$disable_sale = $sale->disable_sale();

if($disable_sale){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}