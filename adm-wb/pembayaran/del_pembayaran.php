<?php
require_once('../../process/db.php');

$byr	= $_POST['id_byr'];

$del_byr="DELETE FROM
			jenis_pembayaran
		WHERE id_pembayaran = '$byr'";
mysqli_query($db, $del_byr) or die(mysqli_error($db));
mysqli_close($db);
?>