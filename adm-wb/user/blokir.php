<?php
require_once('../../process/db.php');

$blk	= "UPDATE usr SET
		usrcred = '0'
		WHERE id = '".$_GET['block']."'";
mysqli_query($db, $blk) or die(mysqli_eror($db));
mysqli_close($db);
?>