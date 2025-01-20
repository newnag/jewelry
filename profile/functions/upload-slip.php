<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include('../../config/db.php');
include('../../classes/user.php');

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
  "email" => "",
  "id_file" => "",
  "bookbank" => "",
  "id_customer" => "",
  "id" => ""
);

$data1 = array(
  "user_id" => $_POST['user_id'],
  "item_id" => $_POST['item_id'],
  "interest" => $_POST['interest'],
  "img" => $_FILES['img'],
);

$user = new User($data);
$add_user = $user->upload_slip($data1);

if($add_user){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}