<?php
    require_once("bootstrap.php");
/*
    this function checks if a user can login
    and returns TRUE or FALSE
*/
function canILogin( $username, $password){
    $conn = Db::getInstance();
    $statement = $conn->prepare("select * from user where username = :username");
    $statement->bindParam(":username", $username);
    $statement->execute();
    $result = $statement->fetchAll();
    if(!empty($result)){
        if(password_verify($password, $result[0]['password'])){
            return true;
        }
    }
}