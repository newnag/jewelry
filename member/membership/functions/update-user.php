<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include('../../../config/db.php');
include('../../../classes/user.php');

//////////////////////////////////////////////////////

$data = array(
  "conn" => $conn,
  "fullname" => $_POST['fullname'],
  "sex" => $_POST['sex'],
  "dob" => $_POST['dob'],
  "phone" => $_POST['phone'],
  "address" => $_POST['address'],
  "id_no" => $_POST['id_no'],
  "line_id" => $_POST['line_id'],
  "email" => $_POST['email'],
  "id_file" => "",
  "bookbank" => "",
  "id_customer" => "",
  "id" => $_POST['id']
);

$point = $_POST['point'];

$user = new User($data);
$add_user = $user->update($point);

if($add_user){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}