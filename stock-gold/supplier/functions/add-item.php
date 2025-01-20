<?php

include('../../../config/db.php');
include('../../../classes/supplier.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "supplier_name" => $_POST['supplier_name'],
  // "tax_id" => "",
  // "id" => ""
);

$tax_id = $_POST['tax_id'];
$type_sup = $_POST['type_supplier'];

$type = new Supplier($data);
$add_type = $type->add_supplier($type_sup,$tax_id);

if($add_type){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}