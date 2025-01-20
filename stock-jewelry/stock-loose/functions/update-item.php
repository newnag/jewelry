<?php

include('../../../config/db.php');
include('../../../classes/stock-jewelry-loose.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "supplier" => $_POST['supplier'],
  "supplier_lot" => $_POST['supplier_lot'],
  "stock_date" => $_POST['stock_date'],
  "price" => $_POST['price'],
  "weight" => $_POST['weight'],
  "amount" => $_POST['amount'],
  "weight_total" => $_POST['weight_total'],
  "size" => $_POST['size'],
  "color" => $_POST['color'],
  "clarity" => $_POST['clarity'],
  "proportion_cut" => $_POST['proportion_cut'],
  "symmetry_cut" => $_POST['symmetry_cut'],
  "polish_cut" => $_POST['polish_cut'],
  "diamond_shape" => $_POST['diamond_shape'],
  "certificate" => $_POST['certificate'],
  "name_certificate" => $_POST['name_certificate'],
  "id" => $_POST['id']
);

if(isset($_FILES['file_1'])){
  $file = $_FILES['file_1'];
}
else{
  $file = "";
}

// array pic
$pic = array(
  "conn" => $conn,
  "file" => $file
);

$stock = new Stock_jewelry_loose($data);
$add_stock = $stock->update($_POST['other'],$_POST['fluorescent']);
if($add_stock){
  // $add_stock = $stock->update_file($pic['file'],$data['id']);
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}