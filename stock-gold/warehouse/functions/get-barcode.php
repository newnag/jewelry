<?php

include('../../../config/db.php');
include('../../../classes/barcode.php');

//////////////////////////////////////////////////////

$data = array(
    "conn" => $conn,
    "txt" => $_POST['txt']
);

$type_product = $_POST['type'];

$stock = new Barcode($data);
$get_data = $stock->get_item_product("gold",$type_product,2);

if($get_data){
  http_response_code(200);
  echo json_encode($get_data);
}
else{
  http_response_code(404);
  echo "error";
}