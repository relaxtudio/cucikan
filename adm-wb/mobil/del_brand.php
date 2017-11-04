<?php
require_once('../../process/db.php');

$id_del = $_POST['id_del'];
$del_brd = "DELETE FROM brand_mobil
		WHERE id_brand_mobil = '$id_del'";
mysqli_query($db, $del_brd) or die(mysqli_error($db));
mysqli_close($db);
?>