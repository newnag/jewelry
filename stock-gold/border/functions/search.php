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
    "wage_id" => "",
    "wage" => "",
    "sale_date" => "",
    "price_id" => "",
    "price" => "",
    "status" => "",
    "id" => ""
);

$txt = $_POST['txt'];
$type = $_POST['type'];
$cate = $_POST['cate'];


$stock = new Stock_gold($data);
$get_stock = $stock->search(3,$txt,$type,$cate);

if(count($get_stock) > 0){
  http_response_code(200);
  echo json_encode($get_stock);
}
else{
  http_response_code(404);
  echo "error";
}