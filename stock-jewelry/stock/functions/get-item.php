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
    "id" => ""
);

$stock = new Stock_gold($data);
$get_stock = $stock->get();

if(count($get_stock) > 0){
  http_response_code(200);
  echo json_encode($get_stock);
}
else{
  http_response_code(404);
  echo "error";
}