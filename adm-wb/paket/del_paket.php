<?php
require_once('../../process/db.php');

$pkt	= $_POST['del_id'];

$qr_del="DELETE FROM
			paket_cuci
		WHERE id_paket = '$pkt'";
mysqli_query($db, $qr_del) or die(mysqli_error($db));
mysqli_close($db);
?>