<?php
require_once('../../process/db.php');
if(!empty($_POST)){
$id_byr	= mysqli_real_escape_string($db, $_POST['id_byr_ed']);
$tp_byr	= mysqli_real_escape_string($db, $_POST['tp_byr_ed']);
$ket_byr= mysqli_real_escape_string($db, $_POST['ket_byr_ed']);

$upd_byr= "UPDATE jenis_pembayaran SET
		tipe_pembayaran			= '$tp_byr',
		keterangan_pembayaran	= '$ket_byr'
		WHERE id_pembayaran='$id_byr'";
mysqli_query($db, $upd_byr) or die(mysqli_error($db));
mysqli_close($db);
}
?>