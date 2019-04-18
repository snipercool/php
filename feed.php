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
                $post->setTime(time());
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
    <link rel="stylesheet" href="css/master.css">
</head>
<body>
    <form method="post" enctype="multipart/form-data" id="uploadForm">
        <p>Select image to upload:</p>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="text" name="description" id="description">
        <input type="submit" value="Upload Image" name="submit">
    </form>


</body>
</html>