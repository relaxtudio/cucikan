<?php
require_once('../../process/db.php');
if(isset($_POST)){
$tp_byr		= mysqli_real_escape_string($db, $_POST['tipe_pembayaran']);
$ket_byr	= mysqli_real_escape_string($db, $_POST['keterangan_pembayaran']);

$qry_byr = "INSERT INTO jenis_pembayaran(
		`tipe_pembayaran`,
		`keterangan_pembayaran`
		)VALUES(
		'$tp_byr',
		'$ket_byr')";
mysqli_query($db, $qry_byr) or die(mysqli_error($db));
mysqli_close($db);
}
?>