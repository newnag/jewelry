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
  "id_file" => $_FILES['id_file'],
  "bookbank" => $_FILES['bookbank'],
  "id_customer" => "",
  "id" => $_POST['id']
);

$user = new User($data);
$add_user = $user->upload_file_profile();

if($add_user){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}