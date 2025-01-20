<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

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
  "id" => $_POST['item_id']
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
    "file_2" => $file[2],
  ),
  "position" => array(
    "file_id_0" => $_POST['file_id_0'],
    "file_id_1" => $_POST['file_id_1'],
    "file_id_2" => $_POST['file_id_2'],
  )
);

$stock = new Stock_jewelry_product($data);
$add_stock = $stock->update($_POST['product_name'],$_POST['other_cost'],$_POST['show_front']);
if($add_stock){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}