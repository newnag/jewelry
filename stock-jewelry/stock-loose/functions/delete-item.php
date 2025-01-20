<?php

include('../../../config/db.php');
include('../../../classes/stock-jewelry-loose.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "supplier" => "",
  "stock_date" => "",
  "price" => "",
  "weight" => "",
  "diamond_shape" => "",
  "certificate" => "",
  "id" => $_POST['id']
);

$stock = new Stock_jewelry_loose($data);
$add_stock = $stock->delete();
if($add_stock){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}