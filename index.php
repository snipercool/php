<?php
    include_once("bootstrap.php");

    $conn = Db::getInstance();
    $result = $conn->query("SELECT * FROM `user` WHERE `id` = 1");
    $data = $result->fetch();

    
    if (!empty($_POST)) {
        $avatar = $_POST['avatar'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $description = $_POST['description'];
        try {
            $update = $conn->prepare("UPDATE user SET firstname='$firstname', lastname='$lastname', avatar='$avatar', email='$email', username='$username', password='$password', description='$description',  WHERE id = 0");
        $result = $update->execute();
        var_dump($result);
        } catch (\Throwable $th) {
            //throw $th;
            var_dump($th);
        }
        
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
    <div class="head">
        <img src="<?php echo $data['avatar'] ?>" alt="avatar">
        <div class="hidden" id="update"><form action="" method="post"><input type="file" name="avatar" name="avatar"></form></div>
        <button id="avatar">change avatar</button>
    </div>
    <div class="textupdate">
        <form action="" method="post">
        <div>
            <label for="firstname">Firstname</label><br>
            <input type="text" name="firstname" id="firstname" value="<?php echo $data['firstname'] ?>">
        </div>
        <div>
            <label for="lastname">Lastname</label><br>
            <input type="text" name="lastname" id="lastname" value="<?php echo $data['lastname'] ?>">
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
            <label for="password">Firstname</label><br>
            <input type="password" name="password" id="password" value="<?php echo $data['password'] ?>">
        </div>
        <div>
            <label for="description">Description</label><br>
            <textarea name="description" id="description" cols="30" rows="10"><?php echo $data['description'] ?></textarea>
        </div>
        <input type="submit" value="update">
        </form>
    </div>
    <script>
        $('#avatar').click(function(){
            $('#update').removeClass("hidden");
        });
    </script>
</body>
</html>