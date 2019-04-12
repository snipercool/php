<?php 
    require_once("bootstrap.php");

    if(!empty($_POST)){
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from post");
        $statement->execute();
        $result = $statement->fetchAll();
        $temp = explode(".", $_FILES["fileToUpload"]["name"]);
        $newfilename = count($result) . "." . $temp[1];
        $target_dir = "images/uploads/" . count($result);
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $post = new Post();
        if($post->checkImage($target_file)){
            $post->uploadImage($target_file);
            $post->setImage($target_file);
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
    <form method="post" enctype="multipart/form-data">
        <p>Select image to upload:</p>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="text" name="description" id="description">
        <input type="submit" value="Upload Image" name="submit">
    </form>


</body>
</html>