<?php

include('../../../config/db.php');
include('../../../classes/type-product.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "type_name" => "",
  "cate_name" => "",
  "type_id" => "",
  "id" => $_POST['id']
);

$type = new Type_product($data);
$del_type = $type->delete_type();

if($del_type){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}