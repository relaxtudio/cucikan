<?php
require_once('../../process/db.php');

$sql	= "SELECT 
	id_kendaraan,
	id_user,
	nama_brand, 
	produk_mobil,
	tahun,
	warna,
	nama_pemilik,
	nopol
	FROM usr_mobil
	WHERE id_kendaraan = '".$_GET['mobil']."'";
	
$qry	= mysqli_query($db, $sql) or die(mysqli_error($db));
$row	= mysqli_fetch_array($qry);

$a	= $row['id_kendaraan'];
$b	= $row['id_user'];
$c	= $row['nama_brand'];
$d	= $row['produk_mobil'];
$e	= $row['tahun'];
$f	= $row['warna'];
$g	= $row['nama_pemilik'];
$h	= $row['nopol'];	
?>