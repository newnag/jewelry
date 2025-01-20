<?php

include('../../../config/db.php');
include('../../../classes/stock-jewelry-product.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "type_build" => $_POST['type_build'],
  "stock_date" => $_POST['stock_date'],
  "type_product" => $_POST['type_product'],
  "product_no" => $_POST['product_no'],
  "detail" => $_POST['detail'],
  "size" => $_POST['size'],
  "weight" => $_POST['weight'],
  "cost" => $_POST['cost'],
  "cost_id" => $_POST['cost_id'],
  "price_sale" => "",
  "price_id" => "",
  "sale_date" => "",
  "status_product" => $_POST['status_product'],
  "reuse_product" => $_POST['reuse_product'],
  "reuse_detail" => $_POST['reuse_detail'],
  "id" => ""
);

// seting file pic
$file = array();
if(isset($_FILES['file_1'])){
  $file[0] = $_FILES['file_1'];
}
else{
  $file[0] = "";
}
if(isset($_FILES['file_2'])){
  $file[1] = $_FILES['file_2'];
}
else{
  $file[1] = "";
}
if(isset($_FILES['file_3'])){
  $file[2] = $_FILES['file_3'];
}
else{
  $file[2] = "";
}

// array pic
$pic = array(
  "conn" => $conn,
  "file" => array(
    "file_0" => $file[0],
    "file_1" => $file[1],
    "file_2" => $file[2]
  )
);

$stock = new Stock_jewelry_product($data);
$add_stock = $stock->add();
if($add_stock){
  $add_pic = $stock->upload_file($pic,$add_stock);
  if($add_pic){
    http_response_code(200);
    echo "success";
  }
  else{
    http_response_code(404);
    echo "error upload pic";
  }
}
else{
  http_response_code(404);
  echo "error";
}