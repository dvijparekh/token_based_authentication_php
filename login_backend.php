<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$link = mysqli_connect("localhost", "root", "", "test");
$username = "dvij";
$password = "dvij";
$user_id = 1;

$post_data = $_POST;
if (isset($post_data["username"]) && !empty($post_data["username"])) {
    if (isset($post_data["passowrd"]) && !empty($post_data["passowrd"])) {
        if ($post_data["passowrd"] == $password && $post_data["username"] == $username) {
            $current_datetime = date("Y-m-d H:i:s");
            $current_datetime_string = date("YmdHis", strtotime($current_datetime));
            $expiry_datetime = date('Y-m-d H:i:s', strtotime($current_datetime . ' +1 day'));
            $token = get_token($current_datetime_string);
            $sql_query = "INSERT INTO `token_details`(`token`, `created_datetime`, `expire_datetime`, `created_by`) "
                    . "VALUES ('" . $token . "','" . $current_datetime . "','" . $expiry_datetime . "'," . $user_id . ");"; //this user_id is retrived from db while checking username password
            if (mysqli_query($link, $sql_query)) {
                $result_array["token"] = $token;
                $result_array["created_datetime"] = $current_datetime;
                $result_array["expiry_datetime"] = $expiry_datetime;
                echo json_encode($result_array);
            } else {
                echo "ERROR: Could not able to execute $sql_query. " . mysqli_error($link);
            }
        }
    } else {
        echo "password is empty";
    }
} else {
    echo "Username is empty";
}

function get_token($current_datetime_string) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < 10; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString . $current_datetime_string;
}
?>

