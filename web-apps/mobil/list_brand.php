<?php
require_once("../../process/db.php");
	$term = trim(mysqli_real_escape_string($db, $_GET['term']));
	$nama_brand = "SELECT
		id_brand_mobil,
		nama_brand_mobil
		FROM brand_mobil
		WHERE nama_brand_mobil LIKE '%".$term."%'";
	$list_brand = mysqli_query($db,$nama_brand) or die(mysqli_error($db));	
	$return_arr = array();
	while($row=mysqli_fetch_array($list_brand)){
		$return_arr[] = $row['nama_brand_mobil'];
	}
	echo json_encode($return_arr);

?>