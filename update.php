<?php
    include_once("bootstrap.php");

    $conn = Db::getInstance();
    $result = $conn->query("SELECT * FROM `user` WHERE `id` = 1");
    $data = $result->fetch();

    

    if (!empty($_POST)) {
        //$avatar = $_POST['avatar'];
        $target_dir = "images/uploads/";
        $target_file = $target_dir . $_FILES["avatar"]["name"];
        $user = new User();
        $user->setFullname($_POST['fullname']);
		$user->setUsername($_POST['username']);        
		$user->setEmail($_POST['email']);
        $user->setPassword($_POST['password']);
        $user->setDescription($_POST['description']);
        $user->setAvatar($target_file);

        $user->update();
       


       }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/master.css">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body>
    
    <div class="textupdate">
        <form action="" method="post" enctype="multipart/form-data">
        <div class="avatar">
            <img src="<?php echo $data['avatar'] ?>" alt="avatar">
                <div id="update"><input type="file" name="avatar"></div>
        </div>
        <div>
            <label for="fullname">Fullname</label><br>
            <input type="text" name="fullname" id="fullname" value="<?php echo $data['fullname'] ?>">
        </div>
        <div>
            <label for="username">Username</label><br>
            <input type="text" name="username" id="username" value="<?php echo $data['username'] ?>">
        </div>
        <div>
            <label for="email">E-mail</label><br>
            <input type="text" name="email" id="email" value="<?php echo $data['email'] ?>">
        </div>
        <div>
            <label for="password">Password</label><br>
            <input type="password" name="password" id="password" value="<?php echo $data['password'] ?>">
        </div>
        <div>
            <label for="description">Description</label><br>
            <textarea name="description" id="description" cols="30" rows="10"><?php echo $data['description'] ?></textarea>
        </div>
        <input type="submit" value="update">
        </form>
    </div>
</body>
</html>