<?php

include('../../../config/db.php');
include('../../../classes/type-product.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "type_name" => "",
  "cate_name" => $_POST['cate_name'],
  "type_id" => $_POST['type_id'],
  "id" => ""
);

$type = new Type_product($data);
$add_type = $type->add_cate();

if($add_type){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}