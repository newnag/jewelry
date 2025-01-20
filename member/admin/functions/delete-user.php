<?php

include('../../../config/db.php');
include('../../../classes/auth.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "username" => "",
  "password" => "",
  "email" => "",
  "date" => "",
  "remember" => ""
);

$id = $_POST['id'];

$user = new Auth($data);
$del_user = $user->delete($id);

if($del_user){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}