<?php
require_once('../../process/db.php');

$mobil	= $_POST['del_id'];

$qr_del="DELETE FROM
			usr_mobil
		WHERE id_kendaraan = '$mobil'";
mysqli_query($db, $qr_del) or die(mysqli_error($db));
mysqli_close($db);
?>