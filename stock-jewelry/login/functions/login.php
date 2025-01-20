<?php

include('../../../config/db.php');
include('../../../classes/auth.php');

$data = array(
    "conn" => $conn,
    "username" => $_POST['username'], //admin
    "password" => $_POST['password'], //folDA545@dfd255
    "email" => "",
    "date" => date("Y-m-d H:i:s"),
    "remember" => $_POST['remember']
);

$auth = new Auth($data);
$login = $auth->login();
$data_login = json_decode($login);

if($data_login->status == 200){
    echo true;
}
else{
    echo false;
}