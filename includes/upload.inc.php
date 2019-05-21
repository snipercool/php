<?php

    $filter = '';
    if (!empty($_POST)) {
        $post = new Post();
        $image = $post->createImageName();
        if ($post->checkImage($image)) {
            $post->setImage($image);
            if ($post->checkDescription($_POST['description'])) {
                $post->setDescription($_POST['description']);
                $post->setFilter($_POST['filter']);
                $post->uploadImage();
                $post->setCity();
                header('Location: index.php');
            }
        }
    }
?>

<div id="formContainer" class="hidden">
    <div class="close">x</div>
    <form method="post" enctype="multipart/form-data" id="uploadForm">
        <p>Select image to upload:</p>
        <div class="filter">
            <img src="#" alt="preview" id="preview">
            <div class="arrow arrowNext">></div>
            <div class="arrow arrowPrevious"><</div>
        </div>
        <input type="file" name="fileToUpload" id="fileToUpload" onchange="loadFile(event)">
        <textarea name="description" id="description" placeholder="Write about your picture"></textarea>
        <input type="text" id="filterField" name="filter" class="hidden">
        <input type="text" id="location" name="location" class="hidden">
        <button type="submit" value="Upload Image" name="submit" id="btnSubmit" class="btn">Submit</button>
    </form>
    
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script>
    var loadFile = function(event) {
        var reader = new FileReader();
        reader.onload = function(){
        var preview = document.getElementById('preview');
        preview.src = reader.result;
        var filter = document.querySelector(".filter");
        filter.style.visibility = "visible";
        };
        reader.readAsDataURL(event.target.files[0]);
    };

    var filter = 0;

    $('.arrowNext').on("click", function(){
        if(filter < 26 ){
            filter++;
        }else{
            filter = 0;
        }
        applyFilter(filter);
    });

    $('.arrowPrevious').on('click', function(){
        if(filter > 0 ){
            filter--;
        }else{
            filter = 26;
        }
        applyFilter(filter);
    })

    function applyFilter(filter){
        $('#preview').removeClass();
        $('#filterField').val("");

        if(filter == 1){
            $('#preview').addClass("_1977");
            $('#filterField').val('_1977');
        }else if(filter == 2){
            $('#preview').addClass("aden");
            $('#filterField').val('aden')
        }else if(filter == 3){
            $('#preview').addClass("brannan");
            $('#filterField').val('brannan');
        }else if(filter == 4){
            $('#preview').addClass("brooklyn");
            $('#filterField').val('brooklyn');
        }else if(filter == 5){
            $('#preview').addClass("clarendon");
            $('#filterField').val('claredon')
        }else if(filter == 6){
            $('#preview').addClass("earlybird");
            $('#filterField').val('earlybird');
        }else if(filter == 7){
            $('#preview').addClass("gingham");
            $('#filterField').val('gingham');
        }else if(filter == 8){
            $('#preview').addClass("hudson");
            $('#filterField').val('hudson');
        }else if(filter == 9){
            $('#preview').addClass("inkwell");
            $('#filterField').val('inkwell');
        }else if(filter == 10){
            $('#preview').addClass("kelvin");
            $('#filterField').val('kelvin');
        }else if(filter == 11){
            $('#preview').addClass("lark");
            $('#filterField').val('lark');
        }else if(filter == 12){
            $('#preview').addClass("lofi");
            $('#filterField').val('lofi');
        }else if(filter == 13){
            $('#preview').addClass("maven");
            $('#filterField').val('maven');
        }else if(filter == 14){
            $('#preview').addClass("mayfair");
            $('#filterField').val('mayfair');
        }else if(filter == 15){
            $('#preview').addClass("moon");
            $('#filterField').val('moon');
        }else if(filter == 16){
            $('#preview').addClass("nashville");
            $('#filterField').val('nashville');
        }else if(filter == 17){
            $('#preview').addClass("perpetua");
            $('#filterField').val('perpetua');
        }else if(filter == 18){
            $('#preview').addClass("reyes");
            $('#filterField').val('reyes');
        }else if(filter == 19){
            $('#preview').addClass("rise");
            $('#filterField').val('rise');
        }else if(filter == 20){
            $('#preview').addClass("slumber");
            $('#filterField').val('slumber');
        }else if(filter == 21){
            $('#preview').addClass("stinson");
            $('#filterField').val('stinson');
        }else if(filter == 22){
            $('#preview').addClass("toaster");
            $('#filterField').val('toaster');
        }else if(filter == 23){
            $('#preview').addClass("valencia");
            $('#filterField').val('valencia');
        }else if(filter == 24){
            $('#preview').addClass("walden");
            $('#filterField').val('walden');
        }else if(filter == 25){
            $('#preview').addClass("willow");
            $('#filterField').val('willow');
        }else if(filter == 26){
            $('#preview').addClass("xpro2");
            $('#filterField').val('xpro2');
        }
        
    }

    $("#formContainer").on('click', function(){
        $(this).addClass('hidden');
    });

    $('#uploadForm').on('click', function(e){
        e.stopPropagation();
    })


</script>