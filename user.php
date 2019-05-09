<?php 
    require_once("bootstrap.php");

    $post = new Post();
    $posts = $post->getUserPosts();

    $user = new User();
    $u = $user->getUserById($_GET['id']);

    $follow = new Follow();
    $check = $follow->checkFollow((int)$_GET['id']);
    


    


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
            <img src="<?php echo $u['avatar'] ?>" alt="avatar">
            <label for="username"><?php echo $u['username'] ?></label>
        </div>
        <div>
            <label for="fullname"><?php echo $u['fullname'] ?></label><br>
            <?php if ($u['id'] == $_SESSION['user'][0]): ?>
                <div>
                    <a href="update.php" class="userBtn">Update</a>
                </div>
                <?php elseif ($u['id'] != $_SESSION['user'][0]): ?>
                <div>
                    <a href="" id="follow" data-index="<?php echo $_GET['id'] ?>" class="userBtn"><?php echo $check ?></a>
                </div>
            <?php endif ?>
        </div>
        <div>
            <label for="description"><?php echo $u['description'] ?></label>
        </div>
        
    </div>
    <div class="postwall">
        <?php foreach ($posts as $p):?>
        <div class="post">
            <img class="post-image" src="<?php echo $p['image']?>" alt="post">
        </div>
        <?php endforeach; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="js/follow_user.js"></script>
</body>
</html>