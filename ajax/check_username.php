<?php
    include_once("../classes/user.class.php");
    include_once("../classes/db.class.php");
    $username = $_POST['username'];
    $response = [];
    if( User::isUsernameAvailable($username) ){
        $response['status'] = 'success';   
    }
    else {
        $response['status'] = 'error';
        $response['error'] = 'Sorry, this username has already been taken';   
    }
    header('Content-Type: application/json');
    echo json_encode($response);
