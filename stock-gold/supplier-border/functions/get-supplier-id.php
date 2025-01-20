<?php

include('../../../config/db.php');
include('../../../classes/supplier.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "supplier_name" => "",
  "id" => $_POST['id']
);

$type = new Supplier($data);
$get = $type->get_id();

if($get){
  http_response_code(200);
  echo json_encode($get);
}
else{
  http_response_code(404);
  echo "error";
}