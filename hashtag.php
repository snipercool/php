<?php 
    require_once("bootstrap.php");

    $hashtag = new Hashtag();

    
    $hashtag->setHashtag("#" . $_GET['hashtag']);

    $hashtagId = $hashtag->getIdByHashtag();


    $post = new Post();
    $posts = $post->getPostsByHashtag('#' . $_GET['hashtag']);

    $follow = new Follow();
    $check = $follow->checkFollowHashtag($hashtagId);
    


    


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/master.css">
    <title>Document</title>
</head>
<body>
    <div>
        <label for="hashtag"><?php echo $_GET['hashtag'] ?></label><br>

            <div>
                <a href="" id="follow" data-index="<?php echo $hashtagId ?>" class="userBtn"><?php echo $check ?></a>
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
    <script src="js/follow_hashtag.js"></script>
</body>
</html>