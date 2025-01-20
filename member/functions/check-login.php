<?php

function check_login($conn){
    $data = array(
        "conn" => $conn,
        "username" => "",
        "email" => "",
        "password" => "",
        "phone" => "",
        "date" => "",
        "remember" => ""
    );
    
    $auth = new Auth($data);
     
    if(!$auth->check_login()){
        header("Location: https://thavorn-jewelry.com/member/login/");
    }
}

?>