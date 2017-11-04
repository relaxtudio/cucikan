<?php 
require_once('../../process/db.php');

if(!empty($_POST))
	{
		
	//dapatkan data form input mobil
	$mbl1	= $_POST['id_user'];
	$mbl2	= $_POST['brand'];
	$mbl3	= mysqli_real_escape_string($db, $_POST['produk_mobil']);
	$mbl4	= mysqli_real_escape_string($db, $_POST['tahun']);
	$mbl5	= mysqli_real_escape_string($db, $_POST['warna']);
	$mbl6	= mysqli_real_escape_string($db, $_POST['nama_pemilik']);
	$mbl7	= mysqli_real_escape_string($db, $_POST['nopol']);
	
	
	$sql	= "INSERT INTO `usr_mobil`(
	`id_user`,
	`nama_brand`,
	`produk_mobil`,
	`tahun`,
	`warna`,
	`nama_pemilik`,
	`nopol`
	)VALUES(
	'$mbl1',
	'$mbl2',
	'$mbl3',
	'$mbl4',
	'$mbl5',
	'$mbl6',
	'$mbl7'
	)";
	mysqli_query($db,$sql) or die(mysqli_error($db));
	mysqli_close($db);
		
	//echo '<script type="text/javascript">';
	//echo 'alert("Data berhasil tersimpan.")';
	//echo '</script>';
	//echo '<meta http-equiv="refresh" content="0; url=../../web-apps/home.php">';
		
	}
?>