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
$del_cate = $type->delete_cate();

if($del_cate){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}