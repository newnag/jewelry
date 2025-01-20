<?php

include('../../../config/db.php');
include('../../../classes/member-backend.php');

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
  "id" => ""
);

$user = new member_backend($data);
$get_user = $user->get_member_graph(2);

if(count($get_user) > 0){
  http_response_code(200);
  echo json_encode($get_user);
}
else{
  http_response_code(404);
  echo "error";
}