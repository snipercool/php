<?php
/*
    this function checks if a user can login
    and returns TRUE or FALSE
*/
function canILogin( $username, $password){
    $conn = new mysqli("localhost", "root", "root", "php");

    $query = "select * from user where email = '".$conn->real_escape_string($username)."'";
    $result = $conn->query($query);
    if($result->num_rows == 1){
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['password'])){
            return true;
        }
    }
    return false;
}