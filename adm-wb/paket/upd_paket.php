<?php
require_once('../../process/db.php');
if(!empty($_POST)){
$id_pkt	= mysqli_real_escape_string($db, $_POST['id_paket_ed']);
$nm_pkt	= mysqli_real_escape_string($db, $_POST['nama_paket_ed']);
$hrg_pkt= mysqli_real_escape_string($db, $_POST['harga_ed']);
$ket_pkt= mysqli_real_escape_string($db, $_POST['keterangan_ed']);

$upd_pkt= "UPDATE paket_cuci SET
		nama_paket	= '$nm_pkt',
		harga		= '$hrg_pkt',
		keterangan	= '$ket_pkt'
		WHERE id_paket='$id_pkt'";
mysqli_query($db, $upd_pkt) or die(mysqli_error($db));
mysqli_close($db);
}
?>