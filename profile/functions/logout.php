<?php

include('../../config/db.php');
include('../../classes/user.php');

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

$auth = new User($data);
$login = $auth->user_logout();

if($login){
    echo true;
}
else{
    echo false;
}