<?php
$a	= "localhost"; //server
$b	= "root"; //username
$c	= ""; //password
$d	= "cucikan"; //db

$db	= mysqli_connect($a,$b,$c,$d)
	or die (mysqli_error($db)); 
?>