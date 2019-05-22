<div class="navContainer mobile">
    <div class="nav">
        <a class="nav--searchimg" href="includes/search.inc.php"><img src="images/search.png" alt="search"></a>
        <div class="btn uploadBtn" id="uploadBtn"><img src="images/add.png" alt="add"></div>
        <a class="nav--userimg" href="user.php?id=<?php echo $_SESSION['user'][0];?>"><img src="images/account.png" alt="user"></a>
    </div>
    <?php require_once('includes/search.inc.php'); ?>
</div>


<script>
    uploadBtn = document.querySelector("#uploadBtn");
    form = document.querySelector("#formContainer")

    uploadBtn.addEventListener("click", function(){
        form.classList.remove('hidden');
    })
</script>

