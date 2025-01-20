<?php

include("../classes/auth.php");

$data = array(
    "conn" => "",
    "conn" => "",
    "conn" => "",
    "conn" => "",
);

$auth = new Auth($data);
$check_login = $auth->check_login();

if($check_login){
    header("Location: https://thavorn-jewelry.com/stock-gold/dashboard/");
}
else{
    header("Location: https://thavorn-jewelry.com/stock-gold/login/");
}
