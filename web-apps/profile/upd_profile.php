<?php
require_once('../../process/db.php');

if(!empty($_POST)){
	//security measyres
	$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
	$password = hash('sha256', $_POST['password'] . $salt); 
	for($round = 0; $round < 65536; $round++){ $password = hash('sha256', $password . $salt); }
	
	$id			= $_POST['id'];
	$username	= $_POST['username'];
	$password	= $password;
	$salt		= $salt;
	$email		= filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
	$nama		= $_POST['nama'];
	$gender		= $_POST['gender'];
	$alamat		= $_POST['alamat'];
	$kota_kab	= $_POST['kota_kab'];
	$kecamatan	= $_POST['kecamatan'];
	$telepon	= $_POST['telepon'];
	
	$upd_usr	= "
		UPDATE usr SET
			username	= '$username',
			password	= '$password',
			salt		= '$salt',
			email		= '$email'
		WHERE id = '$id'
		";
	$upd_detail	= "
		UPDATE usr_detail SET
			nama		= '$nama',
			gender		= '$gender',
			alamat		= '$alamat',
			kota_kab	= '$kota_kab',
			kecamatan	= '$kecamatan',
			telepon		= '$telepon'
		WHERE id_user	= '$id'
		";
	mysqli_query($db, $upd_usr) or die(mysqli_error($db));
	mysqli_query($db, $upd_detail) or die(mysqli_error($db));
	mysqli_close($db);
	//header("Location: ../../web-apps/home.php");  
}
?>