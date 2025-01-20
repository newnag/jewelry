<?php

function check_login($conn){
    $data = array(
        "conn" => $conn,
        "username" => "",
        "password" => "",
        "phone" => "",
        "email" => "",
        "date" => "",
        "remember" => ""
    );
    
    $auth = new Auth($data);
     
    if(!$auth->check_login()){
        header("Location: https://thavorn-jewelry.com/stock-jewelry/login");
    }
}
