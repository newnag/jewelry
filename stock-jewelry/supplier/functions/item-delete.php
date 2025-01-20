<?php

include('../../../config/db.php');
include('../../../classes/supplier.php');

//////////////////////////////////////////////////////

$data = array(
    "conn" => $conn,
    "supplier_name" => $_POST['name'],
    "id" => $_POST['id']
);

$type = new Supplier($data);
$del_type = $type->delete();

if($del_type){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}