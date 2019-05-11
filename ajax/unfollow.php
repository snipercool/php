<?php
    include_once("../bootstrap.php");
    $user = $_SESSION['user'][0];
    $followuser = $_POST['followUserId'];

    $conn = Db::getInstance();
    $stmt = $conn->prepare("DELETE FROM `follow` WHERE followuser_id = :followuser_id AND user_id = :user_id");
    $stmt->bindParam(":followuser_id", $followuser);
    $stmt->bindParam(":user_id", $user);
    $stmt->execute();
    
    