<?php
require('../../process/config.php');
    if(empty($_SESSION['user'])) 
    {
        header('Location: ../../index.php');
        die("Redirecting to index.php"); 
    }
require_once('../../process/db.php');
$usr	= $_SESSION['user']['id'];
$sql	= "SELECT
		usr.id,
		usr.username,
		usr.email,
		usr_detail.nama,
		usr_detail.gender,
		usr_detail.alamat,
		usr_detail.kota_kab,
		usr_detail.kecamatan,
		usr_detail.telepon
	FROM usr
	INNER JOIN usr_detail
	ON usr.id = usr_detail.id_user
	WHERE usr.id = '$usr'
	";
	
$qry	= mysqli_query($db, $sql) or die(mysqli_error($db));
$row	= mysqli_fetch_array($qry);

$pr1	= $row['id'];
$pr2	= $row['username'];
$pr3	= $row['email'];
$pr4	= $row['nama'];
$pr5	= $row['gender'];
$pr6	= $row['alamat'];
$pr7	= $row['kota_kab'];
$pr8	= $row['kecamatan'];
$pr9	= $row['telepon'];	
?>