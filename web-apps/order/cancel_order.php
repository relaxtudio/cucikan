<?php
require_once('../../process/db.php');
$stats = "Cancelled";
$qr_cancel="UPDATE order_cuci SET
		status = '$stats'
		WHERE id_order = '".$_GET['cancel']."'";
mysqli_query($db, $qr_cancel) or die(mysqli_error($db));
mysqli_close($db);
?>