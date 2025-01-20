<?php

include('../../../config/db.php');
include('../../../classes/member-reward.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "name" => $_POST['name'],
  "point" => $_POST['point'],
  "amount" => $_POST['amount'],
  "detail" => $_POST['detail'],
  "id" => $_POST['id']
);


$stock = new Member_reward($data);
$add_stock = $stock->update();
if($add_stock){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}