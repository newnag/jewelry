<?php

include('../../../config/db.php');
include('../../../classes/stock-jewelry-body.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "supplier" => "",
  "stock_date" => "",
  "price" => "",
  "weight" => "",
  "amount" => "",
  "type" => "",
  "id" => $_POST['id']
);

$stock = new Stock_jewelry_body($data);
$get_stock = $stock->get_data();

if(count($get_stock) > 0){
  http_response_code(200);
  echo json_encode($get_stock);
}
else{
  http_response_code(404);
  echo "error";
}