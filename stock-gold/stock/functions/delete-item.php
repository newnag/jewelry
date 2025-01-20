<?php

include('../../../config/db.php');
include('../../../classes/stock-gold.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "supplier_type" => "",
  "product_no" => "",
  "product_cate" => "",
  "weight" => "",
  "detail" => "",
  "import_date" => "",
  "cost_id" => "",
  "cost" => "",
  "sale_date" => "",
  "price_id" => "",
  "price" => "",
  "status" => "",
  "id" => $_POST['id']
);

$stock = new Stock_gold($data);
$del_item = $stock->delete();

if($del_item){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}