<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include('../../../config/db.php');
include('../../../classes/stock-jewelry-order.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "paper_no" => $_POST['paper_no'],
  "type_product" => $_POST['product_type'],
  "customer_id" => $_POST['user_id'],
  "customer_name" => $_POST['customer_name'],
  "detail" => $_POST['detail'],
  "order_date" => $_POST['order_date'],
  "estimate_price" => $_POST['estimate_price'],
  "deposit" => $_POST['deposit'],
  "price" => $_POST['price'],
  "cost" => $_POST['cost'],
  "weight" => $_POST['weight'],
  "size" => $_POST['size'],
  "supplier_body_id" => $_POST['supplier_body_id'],
  "supplier_body_name" => $_POST['supplier_body_name'],
  "supplier_body_lot" => $_POST['supplier_body_lot'],
  "supplier_body_weight" => $_POST['supplier_body_weight'],
  "supplier_body_cost" => $_POST['supplier_body_cost'],
  "supplier_body_type" => $_POST['supplier_body_type'],
  "supplier_loose" => $_POST['loose_diamond'],
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

$stock = new Stock_jewelry_order($data);
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