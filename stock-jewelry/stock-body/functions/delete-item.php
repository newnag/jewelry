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
  "color" => "",
  "type" => "",
  "si" => "",
  "weight_total" => "",
  "percent_gold" => "",
  "id" => $_POST['id']
);

$stock = new Stock_jewelry_body($data);
$add_stock = $stock->delete();
if($add_stock){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}