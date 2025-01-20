<?php

include('../../../config/db.php');
include('../../../classes/stock-jewelry-body.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "supplier" => $_POST['supplier'],
  "stock_date" => $_POST['stock_date'],
  "price" => $_POST['price'],
  "weight" => $_POST['weight'],
  "amount" => $_POST['amount'],
  "color" => $_POST['color'],
  "type" => $_POST['type'],
  "si" => $_POST['si'],
  "weight_total" => $_POST['weight_total'],
  "percent_gold" => $_POST['percent_gold'],
  "id" => $_POST['id']
);

$stock = new Stock_jewelry_body($data);
$add_stock = $stock->update($_POST['note']);
if($add_stock){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}