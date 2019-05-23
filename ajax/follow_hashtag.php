<?php
    include_once("../bootstrap.php");
    $user = $_SESSION['user'][0];
    $hashtag = $_POST['hashtagId'];

    $conn = Db::getInstance();
    $stmt = $conn->prepare("INSERT INTO `followhashtag` (hashtag_id, user_id) values (:hashtag_id, :user_id)");
    $stmt->bindParam(":hashtag_id", $hashtag);
    $stmt->bindParam(":user_id", $user);
    $stmt->execute();