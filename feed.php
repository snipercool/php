<?php 
    require_once("bootstrap.php");

    if(!empty($_POST)){
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from post");
        $statement->execute();
        $result = $statement->fetchAll();
        $temp = explode(".", $_FILES["fileToUpload"]["name"]);
        $newfilename = count($result) . "." . $temp[1];
        $target_dir = "images/uploads/";
        $target_file = $target_dir . $newfilename;
        $post = new Post();
        if($post->checkImage($target_file)){
            $post->setImage($target_file);
            if($post->checkDescription($_POST["description"])){
                $post->setDescription($_POST["description"]);
                $post->uploadImage();
            }
        }
    }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans|Londrina+Solid" rel="stylesheet"> 
    <link rel="stylesheet" href="css/master.css">
</head>
<body>
    <div id="formContainer">
        <form method="post" enctype="multipart/form-data" id="uploadForm">
            <p>Select image to upload:</p>
            <img src="#" alt="preview" id="preview">
            <input type="file" name="fileToUpload" id="fileToUpload" onchange="loadFile(event)">
            <textarea name="description" id="description" placeholder="Write about your picture"></textarea>
            <button type="submit" value="Upload Image" name="submit" id="btnSubmit" class="btn">Submit</button>
        </form>
    </div>



<script>
    var loadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var preview = document.getElementById('preview');
      preview.src = reader.result;
      preview.style.visibility = "visible";
    };
    reader.readAsDataURL(event.target.files[0]);
  };
</script>
</body>
</html>