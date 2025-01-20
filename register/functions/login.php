<?php

include('../../config/db.php');
include('../../classes/user.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "fullname" => "",
  "sex" => "",
  "dob" => "",
  "phone" => $_POST['phone'],
  "address" => "",
  "id_no" => $_POST['id_no'],
  "line_id" => "",
  "email" => "",
  "id_file" => "",
  "bookbank" => "",
  "id_customer" => "",
  "id" => ""
);

$user = new User($data);
$add_user = $user->user_login();

if($add_user){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}