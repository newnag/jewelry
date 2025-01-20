<?php

include('../../../config/db.php');
include('../../../classes/barcode.php');

//////////////////////////////////////////////////////

$data = array(
    "conn" => $conn,
    "txt" => $_POST['txt']
);

$product = $_POST['data'];

// print_r($product);

$stock = new Barcode($data);
$get_data = $stock->get_product_gold($product);

if($get_data){
  http_response_code(200);
  echo json_encode($get_data);
}
else{
  http_response_code(404);
  echo "error";
}