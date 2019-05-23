<div class="navContainer desktop">
    <div class="nav">
        <a id="searchBtn" href="#"><img class="nav--searchimg" src="images/search.png" alt="search"></a>
        <div class="btn uploadBtn" id="uploadBtn"><img src="images/add.png" alt="add"></div>
        <a href="user.php?id=<?php $_SESSION['user'][0];?>"><img class="nav--userimg" src="images/account.png" alt="user"></a>
    </div>
</div>


<script>
    uploadBtn = document.querySelector("#uploadBtn");
    form = document.querySelector("#formContainer")

    uploadBtn.addEventListener("click", function(){
        form.classList.remove('hidden');
    })
    
    searchBtn = document.querySelector('#searchBtn');

</script>

