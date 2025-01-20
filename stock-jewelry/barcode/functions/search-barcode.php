<?php

include('../../../config/db.php');
include('../../../classes/sale-jewelry.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "barcode" => $_POST['barcode'],
  "cus_id" => "",
  "item_id" => "",
  "sale_date" => "",
  "sale_price" => "",
  "sell_price" => "",
  "point_received" => "",
);

  $sale = new Sale_jewelry($data);
  $get_sale = $sale->get_table();

if(count($get_sale) > 0){
  http_response_code(200);
  echo json_encode($get_sale);
}
else{
  http_response_code(404);
  echo "error";
}