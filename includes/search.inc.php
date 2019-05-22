<<<<<<< HEAD
<?php
require_once '../bootstrap.php';
?>
<form action="search.inc.php?search" method="post" class="searchform">
<input type="search" name="search" class="searchform__input">
=======
<form name="postsearch" action="?search" method="post" class="searchform">
>>>>>>> feature15
<input type="submit" name="submit" value="Search">
<input type="search" name="search" class="searchform__input">
</form>
<?php
if (isset($_POST['submit'])) {
    if (isset($_GET['search'])) {
        if (preg_match('/^[A-Za-z]+/', $_POST['search'])) {
            $search = $_POST['search'];
            $conn = Db::getInstance();
            $stmt = $conn->prepare("select id, fullname, username, Null as tag from user where fullname LIKE '%".$search."%' or username LIKE '%".$search."%' OR city like '%$search%'
            UNION
            select id, Null as fullname, Null as username, tag from tag where tag LIKE '%".$search."%'");
            $stmt->execute();

<<<<<<< HEAD
            while ($row = $stmt->fetchAll(\PDO::FETCH_ASSOC)) {
                if ($row[0]['fullname'] != null) {
                    $FullName = $row[0]['fullname'];
                    $UserName = $row[0]['username'];
                    $ID = $row[0]['id'];
                    echo "<ul>\n";
                    echo '<li>'."<a  href=\"user.php?id=$ID\"><p>".$UserName.'</p><p> '.$FullName."</p></a></li>\n";
                    echo '</ul>';
                    echo '<hr>';
                } elseif ($row[0]['tag'] != null) {
                    $tag = $row[0]['tag'];
                    $ID = $row[0]['id'];
                    echo "<ul>\n";
                    echo '<li>'."<a  href=\"tag.php?tag=$tag\"><p>".$tag."</p></a></li>\n";
                    echo '</ul>';
                    echo '<hr>';
                }
                var_dump($row);
=======
            while($row=$stmt->fetchAll(\PDO::FETCH_ASSOC)){
                if ($row[0]['fullname'] != NULL) {
                    $FullName=$row[0]['fullname']; 
                    $UserName=$row[0]['username']; 
                    $ID=$row[0]['id'];
                    echo "<ul class='list'>\n"; 
                    echo "<li class='list--items'>" . "<a  href=\"user.php?id=$ID\"><p>" .$UserName . "</p><p> " . $FullName .  "</p></a></li>\n"; 
                    echo "</ul>"; 
                    echo "<hr>";
                }elseif ($row[0]['tag'] != NULL) {
                    $tag=$row[0]['tag'];
                    $ID=$row[0]['id'];
                    echo "<ul class='list'>\n"; 
                    echo "<li class='list--items'>" . "<a  href=\"tag.php?tag=$tag\"><p>" .$tag . "</p></a></li>\n"; 
                    echo "</ul>"; 
                    echo "<hr>";
               }   
               
>>>>>>> feature15
            }
        }
    } else {
        echo '<p>Nothing Found</p>';
    }
}

?>