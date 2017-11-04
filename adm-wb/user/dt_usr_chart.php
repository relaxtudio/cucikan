<?php
require_once('../../process/db.php');

$qry_u	= "SELECT 
	SUM(CASE WHEN usrcred='0' then 1 else 0 END) AS diblokir,
	SUM(CASE WHEN usrcred='1' then 1 else 0 END) AS admin,
	SUM(CASE WHEN usrcred='2' then 1 else 0 END) AS aktif,
	COUNT(id) AS total
	FROM usr
	WHERE usrcred != 1";
$t_user	= mysqli_query($db, $qry_u) or die(mysqli_error($db));
$usr_a = array();
foreach ( $t_user as $row){
	$usr_a[] = $row;
}
mysqli_close($db);
print json_encode($usr_a);
?>
