<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$link = mysqli_connect("localhost", "root", "", "test");
$token = $_GET["token"];
if (isset($token) && !empty($token)) {
    $data = mysqli_query($link, "select expire_datetime from token_details where token ='" . trim($token) . "' LIMIT 1");
    if ($row=mysqli_fetch_row($data)) {
        $current_datetime = date("Y-m-d H:i:s");
        if($row[0] > $current_datetime){
            print("return data requested");
        } else{
            print("Token has expired please login and take new token");
        }
    } else {
        echo "Token is not valid";
    }
}else{
    echo "Token not found";
}
?>