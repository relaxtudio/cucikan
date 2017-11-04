<?php
require_once('../../process/db.php');
if(isset($_POST)){
$nm		= mysqli_real_escape_string($db, $_POST['nama_paket']);
$hrg	= mysqli_real_escape_string($db, $_POST['harga']);
$ket	= mysqli_real_escape_string($db, $_POST['keterangan']);

$qry_pkt = "INSERT INTO paket_cuci(
		`nama_paket`,
		`harga`,
		`keterangan`
		)VALUES(
		'$nm',
		'$hrg',
		'$ket')";
mysqli_query($db, $qry_pkt) or die(mysqli_error($db));
mysqli_close($db);
}
?>