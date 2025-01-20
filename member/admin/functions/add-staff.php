<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include('../../../config/db.php');
include('../../../classes/auth.php');

$data = array(
  "conn" => $conn,
  "username" => $_POST['username'],
  "password" => $_POST['password'],
  "email" => $_POST['email'],
  "date" => date("Y-m-d H:i:s"),
  "remember" => ""
);

$role = $_POST['role'];

$auth = new Auth($data);
$staff = $auth->add_staff($role);

if($staff){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}

?>