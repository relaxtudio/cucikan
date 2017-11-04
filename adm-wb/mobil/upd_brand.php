<?php
require_once('../../process/db.php');
if(!empty($_POST)){
$id_brd	= mysqli_real_escape_string($db, $_POST['id_brand_mobil']);
$nm_brd	= mysqli_real_escape_string($db,$_POST['nama_brand_mobil']);

$upd_br	= "UPDATE brand_mobil SET
		nama_brand_mobil = '$nm_brd'
		WHERE id_brand_mobil = '$id_brd'";
mysqli_query($db,$upd_br) or die(mysqli_error($db));
mysqli_close($db);
}
?>