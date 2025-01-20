<?php

include('../../../config/db.php');
include('../../../classes/supplier.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "supplier_name" => $_POST['name'],
  "id" => $_POST['id']
);

$type_sup = $_POST['type_supplier_edit'];

$type = new Supplier($data);
$add_type = $type->update($type_sup);

if($add_type){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}