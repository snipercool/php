<?php
    require_once("../bootstrap.php");

    if(!empty($_POST)){
        $userId = $_POST['userId'];
        $timesClicked = $_POST['timesClicked'];
        $offset = 20 + $timesClicked*20;
        
        $p = new Post();
        $result = $p->getPosts($offset);

        var_dump($result);

        $response = [
            'status'=> 'success',
            'msg' => 'test'
        ];

        echo json_encode($response);
    }
