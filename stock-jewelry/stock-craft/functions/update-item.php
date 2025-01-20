<?php

include('../../../config/db.php');
include('../../../classes/stock-jewelry-order.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "paper_no" => "",
  "type_product" => "",
  "customer_id" => "",
  "customer_name" => "",
  "detail" => $_POST['detail'],
  "order_date" => "",
  "estimate_price" => $_POST['estimate_price'],
  "deposit" => $_POST['deposit'],
  "price" => $_POST['price'],
  "cost" => $_POST['cost'],
  "weight" => $_POST['weight'],
  "size" => $_POST['size'],
  "supplier_body_id" => "",
  "supplier_body_name" => "",
  "supplier_body_lot" => "",
  "supplier_body_weight" => "",
  "supplier_body_cost" => "",
  "supplier_body_type" => "",
  "supplier_loose" => "",
  "id" => $_POST['id']
);

$stock = new Stock_jewelry_order($data);
$add_stock = $stock->update($_POST['status']);
if($add_stock){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}