<?php
    include_once("../classes/user.class.php");
    include_once("../classes/db.class.php");
    $email = $_POST['email'];
    $response = [];
    if( User::isAccountAvailable($email) ){
        $response['status'] = 'success';   
    }
    else {
        $response['status'] = 'error';
        $response['error'] = 'Sorry, that account has already been taken';   
    }
    header('Content-Type: application/json');
    echo json_encode($response);

