<?php
    include_once("../classes/User.class.php");
    include_once("../classes/Db.class.php");
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
