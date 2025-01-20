<?php

include('../../../config/db.php');
include('../../../classes/type-product.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "type_name" => "",
  "cate_name" => $_POST['cate_name'],
  "type_id" => $_POST['type_id'],
  "id" => $_POST['id']
);

$type = new Type_product($data);
$edit_type = $type->update_cate();

if($edit_type){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}