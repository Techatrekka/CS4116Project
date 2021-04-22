<?php 
    session_start();
    if($_SESSION["user_type"] == "regular") {
        header("Location: ../index.php");
    }
?>