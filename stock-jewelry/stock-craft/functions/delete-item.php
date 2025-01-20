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
  "detail" => "",
  "order_date" => "",
  "estimate_price" => "",
  "deposit" => "",
  "price" => "",
  "cost" => "",
  "weight" => "",
  "size" => "",
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
$del_item = $stock->delete();

if($del_item){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}