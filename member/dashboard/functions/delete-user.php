<?php

include('../../../config/db.php');
include('../../../classes/user.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "fullname" => "",
  "sex" => "",
  "dob" => "",
  "phone" => "",
  "address" => "",
  "id_no" => "",
  "line_id" => "",
  "id_file" => "",
  "bookbank" => "",
  "id_customer" => "",
  "id" => $_POST['id']
);

$user = new User($data);
$del_user = $user->delete();

if($del_user){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}