<?php
    require_once '../bootstrap.php';
    if (!empty($_POST)) {
        $_SESSION['lat'] = $_POST['lat'];
        $_SESSION['long'] = $_POST['long'];

        echo $_SESSION['long'];
    }
