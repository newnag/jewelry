<?php

include('../../../config/db.php');
include('../../../classes/sale-jewelry.php');

//////////////////////////////////////////////////////

$data = array(
    "conn" => $conn,
    "barcode" => $_POST['barcode'],
    "cus_id" => $_POST['cus_id'],
    "item_id" => $_POST['item_id'],
    "date_sale" => $_POST['sale_date'],
    "sale_price" => $_POST['price'],
    "sell_price" => $_POST['sell_price'],
    "point_received" => $_POST['sell_price'],
  );

$sale = new Sale_jewelry($data);
$get_sale = $sale->search_history($_POST['name'],$_POST['date']);

if($get_sale){
  http_response_code(200);
  echo json_encode($get_sale);
}
else{
  http_response_code(404);
  echo "error";
}