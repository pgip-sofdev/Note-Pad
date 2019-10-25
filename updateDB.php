<?php

    session_start();
    ob_start();
    if(array_key_exists("content", $_POST)){

        include("config.php");

        $sql = "UPDATE `users` SET `diary` = '".mysqli_real_escape_string($link,$_POST['content'])."' 
                WHERE id = '".mysqli_real_escape_string($link, $_SESSION['id'])."' LIMIT 1";

        mysqli_query($link,$sql);

    ob_end_flush();
    }
?>