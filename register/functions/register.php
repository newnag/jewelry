<?php

include('../../config/db.php');
include('../../classes/user.php');

//////////////////////////////////////////////////////

$line_user = $_POST['line_user'];
$type_regis = $_POST['type_regis'];

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
  "id_file" => $_FILES['id_file'],
  "bookbank" => $_FILES['bookbank'],
  "id_customer" => "",
  "id" => ""
);

$user = new User($data);
$add_user = $user->add($line_user,$type_regis);

if($add_user){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}