<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include('../../../config/db.php');
include('../../../classes/auth.php');

$data = array(
  "conn" => $conn,
  "username" => "",
  "password" => "",
  "email" => "",
  "date" => "",
  "remember" => ""
);

$id = $_POST['id'];
$role = $_POST['role'];

$auth = new Auth($data);
$staff = $auth->change_role($id,$role);

if($staff){
  http_response_code(200);
  echo "success";
}
else{
  http_response_code(404);
  echo "error";
}

?>