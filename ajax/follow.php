<?php
    include_once("../bootstrap.php");
    $user = $_SESSION['user'][0];
    $followuser = $_POST['followUserId'];

    $conn = Db::getInstance();
    $stmt = $conn->prepare("INSERT INTO `follow` (followuser_id, user_id) values (:followuser_id, :user_id)");
    $stmt->bindParam(":followuser_id", $followuser);
    $stmt->bindParam(":user_id", $user);
    $stmt->execute();