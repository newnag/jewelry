<?php

function check_login($conn){
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
    
    $user = new User($data);
    $check = $user->check_login();
    
    if(!$check){
        header("Location: https://thavorn-jewelry.com/register/");
    }
}
