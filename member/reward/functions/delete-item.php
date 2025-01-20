<?php

include('../../../config/db.php');
include('../../../classes/member-reward.php');

//////////////////////////////////////////////////////

$data = array(
    "conn" => $conn,
    "name" => "",
    "point" => "",
    "amount" => "",
    "detail" => "",
    "id" => $_POST['id']
);


$stock = new Member_reward($data);
$add_stock = $stock->delete();
if($add_stock){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}