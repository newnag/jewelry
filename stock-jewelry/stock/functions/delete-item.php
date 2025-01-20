<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../../../config/db.php');
include('../../../classes/stock-jewelry-product.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "type_build" => "",
  "stock_date" => "",
  "type_product" => "",
  "product_no" => "",
  "detail" => "",
  "size" => "",
  "weight" => "",
  "cost" => "",
  "cost_id" => "",
  "price_sale" => "",
  "price_id" => "",
  "sale_date" => "",
  "status_product" => "",
  "reuse_product" => "",
  "reuse_detail" => "",
  "id" => $_POST['id']
);

$stock = new Stock_jewelry_product($data);
$del_item = $stock->delete();

if($del_item){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}