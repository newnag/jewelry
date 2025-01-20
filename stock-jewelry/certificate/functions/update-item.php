<?php

include('../../../config/db.php');
include('../../../classes/stock-gold.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "supplier_type" => $_POST['supplier_type'],
  "product_no" => $_POST['product_no'],
  "product_cate" => $_POST['product_cate'],
  "weight" => $_POST['weight'],
  "detail" => $_POST['detail'],
  "import_date" => $_POST['import_date'],
  "cost_id" => $_POST['cost_id'],
  "cost" => $_POST['cost'],
  "sale_date" => $_POST['sale_date'],
  "price_id" => $_POST['price_id'],
  "price" => $_POST['price'],
  "status" => $_POST['status'],
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

$stock = new Stock_gold($data);
$add_stock = $stock->update();
if($add_stock){
  $add_pic = $stock->update_file($pic);
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