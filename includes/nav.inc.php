<div class="navContainer">
    <div class="nav">
        <div class="btn uploadBtn" id="uploadBtn"><img src="images/add.png" alt="add"></div>
    </div>
</div>


<script>
    uploadBtn = document.querySelector("#uploadBtn");
    form = document.querySelector("#formContainer")

    uploadBtn.addEventListener("click", function(){
        form.classList.remove('hidden');
    })
</script>

