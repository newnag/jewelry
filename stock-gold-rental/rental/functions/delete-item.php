<?php

include('../../../config/db.php');
include('../../../classes/gold-rental.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "cus_sale_id" => "",
  "product_name" => "",
  "price_rental" => "",
  "interest" => "",
  "detail" => "",
  "value" => "",
  "id" => $_POST['id']
);


$stock = new Gold_rental($data);
$add_stock = $stock->delete_trans();
if($add_stock){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}