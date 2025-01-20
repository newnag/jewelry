<?php

include('../../../config/db.php');
include('../../../classes/stock-equipment.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "name" => $_POST['name'],
  "price" => $_POST['price'],
  "supplier" => $_POST['supplier'],
  "amount" => $_POST['amount'],
  "id" => ""
);


$stock = new Stock_equipment($data);
$add_stock = $stock->add();
if($add_stock){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}