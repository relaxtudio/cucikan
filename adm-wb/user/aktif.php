<?php
require_once('../../process/db.php');

$blk	= "UPDATE usr SET
		usrcred = '2'
		WHERE id = '".$_GET['aktif']."'";
mysqli_query($db, $blk) or die(mysqli_eror($db));
mysqli_close($db);
?>