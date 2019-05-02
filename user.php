<?php 
    require_once("bootstrap.php");

    $conn = Db::getInstance();
    $stmt = $conn->prepare("SELECT * FROM `user` WHERE `id` = :id");
    $stmt->bindParam(":id", $_SESSION['user'][0]);
    $stmt->execute();
    $result = $stmt->fetchAll();

    $mypost = $conn->prepare("SELECT * FROM `post` WHERE `user_id` = :userid");
    $mypost->bindParam(":userid", $_SESSION['user'][0]);
    $mypost->execute();
    $postresult = $mypost->fetchAll();

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        <div class="avatar">
            <img src="<?php echo $result[0]['avatar'] ?>" alt="avatar">
        </div>
        <div>
            <label for="fullname"><?php echo $result[0]['fullname'] ?></label><br>
        </div>
    </div>
    <div></div>
</body>
</html>