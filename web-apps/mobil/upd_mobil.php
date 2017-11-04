<?php
require_once('../../process/db.php');

if(!empty($_POST)){
	$mbl0	= mysqli_real_escape_string($db, $_POST['id_kendaraan']);
	$mbl1	= $_POST['brand'];
	$mbl2	= mysqli_real_escape_string($db, $_POST['produk_mobil']);
	$mbl3	= mysqli_real_escape_string($db, $_POST['tahun']);
	$mbl4	= mysqli_real_escape_string($db, $_POST['warna']);
	$mbl5	= mysqli_real_escape_string($db, $_POST['nama_pemilik']);
	$mbl6	= mysqli_real_escape_string($db, $_POST['nopol']);

	$sqlm		= "UPDATE usr_mobil SET
	nama_brand		= '$mbl1',
	produk_mobil	= '$mbl2',
	tahun			= '$mbl3',
	warna			= '$mbl4',
	nama_pemilik	= '$mbl5',
	nopol			= '$mbl6'
	WHERE id_kendaraan = '$mbl0'
	";
	mysqli_query($db, $sqlm) or die(mysqli_error($db));
	mysqli_close($db);
	
	}
?>