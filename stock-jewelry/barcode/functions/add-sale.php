<?php

include('../../../config/db.php');
include('../../../classes/sale-jewelry.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "barcode" => $_POST['barcode'],
  "cus_id" => $_POST['cus_id'],
  "item_id" => $_POST['item_id'],
  "date_sale" => $_POST['sale_date'],
  "sale_price" => $_POST['price'],
  "sell_price" => $_POST['sell_price'],
  "point_received" => "0",
);

$sale = new Sale_jewelry($data);
$add_sale = $sale->add_sale();

if($add_sale){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}