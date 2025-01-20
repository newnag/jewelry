<?php

include('../../../config/db.php');
include('../../../classes/stock-equipment.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "name" => "",
  "price" => "",
  "amount" => "",
  "supplier" => "",
  "id" => $_POST['id']
);


$stock = new Stock_equipment($data);
$add_stock = $stock->delete();
if($add_stock){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}