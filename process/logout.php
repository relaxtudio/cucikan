<?php 
    require("config.php"); 
    unset($_SESSION['user']);
	$url = "/newcucikan";
    header("Location: $url"); 
    die("Redirecting to: $url");
?>