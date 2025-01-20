<?php

include("../config/evn.php");
include('../config/db.php');
include("../classes/auth.php");

// $data = array(
//     "conn" => $conn,
//     "username" => "admin",
//     "email" => "admin@admin.com",
//     "password" => "folDA545@dfd255",
//     "date" => date("Y-m-d H:i:s"),
//     "remember" => ""
// );

$data = array(
    "conn" => $conn,
    "username" => "",
    "email" => "",
    "password" => "",
    "date" => "",
    "remember" => ""
);

$auth = new Auth($data);
$check_login = $auth->check_login();

if($check_login){
    header("Location: ".root."member/dashboard/");
}
else{
    header("Location: ".root."member/login/");
}