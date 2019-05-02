<?php 
    require_once('bootstrap.php');

    $post = new Post();
    $posts = $post->getPosts();

    $get = $_SESSION['user'][0];


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/master.css">
    <title>Sockening</title>
</head>
<body>
<a  href="<?php echo "user.php?id=$get" ?>"><?php echo $_SESSION['user'][1]; ?></a>
<div class="feedContainer">
    <div class="feed">
        <?php 
        $i = 0;
        foreach($posts as $p): ?>
            <div class="post post<?php echo $i ?>" >
                <img src='<?php echo $p['image']?>' alt="post image" class="post-image">
                <?php 
                    $user = new User();
                    $u = $user->getUserById($p['user_id']);
                ?>
                <div class="post-user">
                    <img src="<?php echo $u['avatar'] ?>" alt="avatar" class="post-avatar">
                    <p class="post-username"><?php echo $u['username'] ?></p>
                </div>
            </div>
            <?php if($i < 2){$i++;}else{$i = 0;}; ?>
        <?php endforeach; ?>
    </div>
</div>

<?php 
    require_once('includes/upload.inc.php');
    require_once('includes/nav.inc.php');
?>
    
</body>
</html>