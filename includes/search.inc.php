<?php 
require_once("../bootstrap.php");
?>
<form action="search.inc.php?search" method="post" class="searchform">
<input type="search" name="search" class="searchform__input">
<input type="submit" name="submit" value="Search">
</form>
<?php
if (isset($_POST['submit'])) {
    if(isset($_GET['search'])){
    if(preg_match("/^[A-Za-z]+/", $_POST['search'])){ 
        $search=$_POST['search'];
        $conn=Db::getInstance();
        $stmt= $conn->prepare("select id, fullname, username, Null as tag from user where fullname LIKE '%".$search."%' or username LIKE '%".$search."%'
        UNION
        select id, Null as fullname, Null as username, tag from tag where tag LIKE '%".$search."%'");
        $stmt->execute();

        
?>