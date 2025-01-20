<?php

include('../config/db.php');
include('../classes/auth.php');

$data = array(
    "conn" => $conn,
    "username" => "", //admin
    "password" => "", //folDA545@dfd255
    "email" => "",
    "date" => "",
    "remember" => ""
);

$auth = new Auth($data);
$login = $auth->logout();

if($login){
    echo true;
}
else{
    echo false;
}