<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include('../../../config/db.php');
include('../../../classes/gold-rental.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "cus_sale_id" => $_POST['cus_sale_id'],
  "product_name" => $_POST['product_name'],
  "price_rental" => $_POST['price_rental'],
  "interest" => $_POST['interest'],
  "detail" => $_POST['detail'],
  "value" => $_POST['value'],
  "id" => ""
);


$stock = new Gold_rental($data);
$add_stock = $stock->add();
if($add_stock){
  if($_FILES['file_1']){
    $stock->upload_file($_FILES['file_1'],$add_stock);
  }

  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}