<?php
require_once('../../process/db.php');
$ord_comp = "UPDATE order_cuci SET
		status = 'Completed'
		WHERE id_order = '".$_GET['ord_id']."'";
mysqli_query($db, $ord_comp) or die(mysqli_error($db));
mysqli_close($db);
?>