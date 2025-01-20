<?php

include('../../../config/db.php');
include('../../../classes/type-product.php');

//////////////////////////////////////////////////////

$data = array(
    "conn" => $conn,
    "type_name" => "",
    "cate_name" => "",
    "type_id" => "",
    "id" => ""
  );

  $type = new Type_product($data);
  $get_type = $type->get_cate("3");

if(count($get_type) > 0){
  http_response_code(200);
  echo json_encode($get_type);
}
else{
  http_response_code(404);
  echo "error";
}