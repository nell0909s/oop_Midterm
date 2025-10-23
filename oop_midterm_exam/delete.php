<?php 
    require_once('database.php');

    if(isset($_GET['id'])){
        $id = (int)$_GET['id'];
        $deleted = $users->delete('user', $id);
        header('Location: home.php');
        exit;
    } else {
        header('Location: home.php');
        exit;
    }
?>