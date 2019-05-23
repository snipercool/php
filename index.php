<?php
    require_once('bootstrap.php');

    if ($_SESSION['user'][0] == null) {
        header('location: login.php');
    } else {
    }

    $post = new Post();

    $get = $_SESSION['user'][0];

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cssgram-cssgram.netdna-ssl.com/cssgram.min.css">
    <link rel="stylesheet" href="dist/css/app.css">
    <title>Sockening</title>
</head>
<body>
<?php 
    require_once('includes/upload.inc.php');
    require_once('includes/nav_mobile.inc.php');
    require_once('includes/nav.inc.php');
    
   
?>
<a class="logo" href="index.php"><img class="logo__images" src="images/Logo.svg" alt="Logo"></a>
<div class="feedContainer">
    <div class="feed" id="feed">
        <?php
            if (isset($_POST['amount'])) {
                $posts = $post->getPosts((int) $_POST['amount']);
            } else {
                $posts = $post->getPosts(20);
            }
        ?>

        <?php
        $i = 0;
        if(empty($posts)): ?>
            <h1>No socks for you :( Follow people or hashtags to see their socks!</h1>
        <?php 
        else:
        foreach ($posts as $p): ?>
        
            <div class="post post<?php echo $i; ?>" data-id="<?php echo $p['id']; ?>">
                
                <img src='<?php echo $p['image']; ?>' alt="post image" class="post-image <?php echo $p['filter']; ?>"  onClick=openModal(<?php echo $p['id']; ?>)>
                <?php
                    $user = new User();
                    $u = $user->getUserById($p['user_id']);

                    $post = new Post();
                    $time = $post->getHumanTime($p['timestamp']);
                ?>
                <div class="post-user">
                    <img src="<?php echo $u['avatar']; ?>" alt="avatar" class="post-avatar">
                    <p class="post-username"><?php echo $u['username']; ?></p>
                    <p class="post-location"> <?php echo $p['location']; ?></p>
                    <p class="post-timestamp"><?php echo $time; ?></p>
                    <p class="post-description"> <?php echo $p['description']; ?></p>
                </div>
                <div><a href="index.php" data-id="<?php echo $p['id']; ?>" id='likebtn' class="like" onclick="updateLike(event)">Like</a> <span class='likes'><?php echo $post->getLikes($p['id']); ?></span> people like this </div>
                <div><a href="index.php" data-id="<?php echo $p['id']; ?>" id='reportbtn' class="inappropriate" onclick="updateInappropriate(event)">Report</a> </div>
            </div>
            <?php if ($i < 2) {
                    ++$i;
                } else {
                    $i = 0;
                } ?>
        <?php endforeach; endif; ?>

    </div>
    <?php if(!empty($posts)): ?>
    <button type="submit" class="btn loadmore" id="loadmore">Load More</button>
    <?php endif; ?>
</div>

<div id="modal" class="hidden">
    <span class="close cursor" onclick="closeModal()">&times;</span>
    <div class="modal-content post">
        <img src="#" alt="modalImage" id="modalImage">
        <p id="modalUsername"></p>
        <p id="modalTimestamp"></p>
        <p id="modalDescription"></p>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  
<script language="JavaScript" type="text/javascript" src="js/get_location.js"></script>
<script language="JavaScript" type="text/javascript" src="js/check_inappropriate.js"></script>
<script type="text/javascript">
    var $amount = 20
    var $userId = <?php echo $_SESSION['user'][0]; ?>;

    <?php if(!empty($posts)): ?>
        $('.feed').load("index.php .feed", {amount: $amount},function(){
            var descriptions = document.querySelectorAll('.post-description');
            for(var i = 0; i < descriptions.length; i++){
                var repl = descriptions[i].innerHTML.replace(/#(\w+)/g, '<a href="hashtag.php?hashtag=$1">#$1</a>');
                descriptions[i].innerHTML = repl;
            };

        })
    <?php endif; ?>


    $("#loadmore").on("click", function(e){
        $amount += 20;
        console.log($amount);
        $(".feed").load("index.php .feed", 
        {amount: $amount}, function(){
            var descriptions = document.querySelector('.post-description').innerHTML;
            for(var i = 0; i < descriptions.length; i++){
                var repl = descriptions[i].replace(/#(\w+)/g, '<a href="hashtag.php?hashtag=$1">#$1</a>');
                descriptions[i].innerHTML = repl;
            };
        });
        
        

        e.preventDefault();

        <?php
        $totalAmount = $post->countPosts();
        ?>

        if(<?php echo $totalAmount; ?> <= $amount){
            $('#loadmore').hide();
        }
    });

    

    function openModal(postId){
        var post = $("[data-id = " + postId + "]")
        var img = post.children(img).attr("src");
        var postUser = post.children('.post-user');
        var username = postUser.children('.post-username').html();
        var description = postUser.children('.post-description').html();
        var timestamp = postUser.children('.post-timestamp').html();

        console.log('img');
        
        $("#modalImage").attr("src", img);
        $("#modalUsername").html(username);
        $("#modalDescription").html(description);
        $("#modalTimestamp").html(timestamp);

        $('#modal').removeClass('hidden');        
    }

    function closeModal(){
        $("#modal").addClass('hidden');
    }

    function updateLike(event) {
        var postId = event.target.getAttribute("data-id");
        var link = $(`.like[data-id = ${postId}]`);
        console.log(link)

        $.ajax({
            method: "POST",
            url: "ajax/like.php",
            data: { postId: postId, }, 
            dataType: 'json'
        })
        .done(function( res ) {
            if (res.status == "liked") {
                var likes = link.next().html();
                likes++;
                link.next().html(likes);	
            } else if (res.status == "unliked") {
                var likes = link.next().html();
                likes--;
                link.next().html(likes);	
            }
        });

        event.preventDefault();  
    };

    function updateInappropriate(event){
        var postId = event.target.getAttribute("data-id");
        var link = $(`.inappropriate[data-id = ${postId}]`);
        console.log(link)

        $.ajax({
        method: "POST",
        url: "ajax/check_inappropriate.php",
        data: { postId: postId }, 
        dataType: 'json'
        })
        .done(function( res ) {
            if (res.status == "flagged") {
                var reports = link.next().html();
                reports++;
                link.next().html(reports);	
            } else if (res.status == "unflagged") {
                var reports = link.next().html();
                reports--;
                link.next().html(reports);	
            }
        });

        event.preventDefault();
    }


</script>
    
</body>
</html>