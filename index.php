<?php
    require_once 'bootstrap.php';

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
        foreach ($posts as $p): ?>
            <div class="post post<?php echo $i; ?>" >
                <img src='<?php echo $p['image']; ?>' alt="post image" class="post-image">
                <?php
                    $user = new User();
                    $u = $user->getUserById($p['user_id']);
                ?>
                <div class="post-user">
                    <img src="<?php echo $u['avatar'] ?>" alt="avatar" class="post-avatar">
                    <a href="user.php?id=<?php echo $p['user_id'] ?>" class="post-username"><?php echo $u['username'] ?></a>
                </div>
                <div><a href="index.php" data-id="<?php echo $p['id']; ?>" id='likebtn' class="like">Like</a> <span class='likes'><?php echo $post->getLikes($p['id']); ?></span> people like this </div>
            </div>
            <?php if ($i < 2) {
                    ++$i;
                } else {
                    $i = 0;
                } ?>
        <?php endforeach; ?>
    </div>
</div>

<?php
    require_once 'includes/upload.inc.php';
    require_once 'includes/nav.inc.php';
?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script language="JavaScript" type="text/javascript" src="js/check_like.js"></script>
</body>
</html>