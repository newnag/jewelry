<?php

include('../../../config/db.php');
include('../../../classes/gold-rental.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "cus_sale_id" => "",
  "product_name" => $_POST['product_name'],
  "price_rental" => $_POST['price_rental'],
  "interest" => $_POST['interest'],
  "detail" => $_POST['detail'],
  "value" => $_POST['value'],
  "id" => $_POST['item_id']
);


$stock = new Gold_rental($data);
$add_stock = $stock->update();
if($add_stock){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}