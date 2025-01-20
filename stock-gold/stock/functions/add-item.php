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
  "size" => $_POST['size'],
  "cost_id" => $_POST['cost_id'],
  "cost" => $_POST['cost'],
  "cost_price" => $_POST['cost_price'],
  "wage" => $_POST['wage'],
  "cost_wage_id" => $_POST['cost_wage_id'],
  "cost_wage" => $_POST['cost_wage'],
  "sale_date" => "",
  "price_id" => "",
  "price" => "",
  "status" => $_POST['status'],
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

$stock = new Stock_gold($data);
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