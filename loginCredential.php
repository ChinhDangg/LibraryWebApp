<?php 
if (!isset($_COOKIE["username"]) || !isset($_COOKIE["user"]))
    header('Location: userCheck.php');
?>