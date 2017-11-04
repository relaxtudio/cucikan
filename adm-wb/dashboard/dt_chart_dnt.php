<?php
require_once('../../process/db.php');

$qry_income	= "SELECT 
	SUM(CASE WHEN order_cuci.status='Order' then 1 else 0 END) AS totalorder,
	SUM(CASE WHEN order_cuci.status='Cancelled' then 1 else 0 END) AS totalcancel,
	SUM(CASE WHEN order_cuci.status='Completed' then 1 else 0 END) AS totalcompleted,
	SUM(CASE WHEN order_cuci.status='Completed' then (1*paket_cuci.harga) else 0 END) AS totalincome
	FROM order_cuci 
	INNER JOIN paket_cuci 
	ON order_cuci.paket = paket_cuci.id_paket";
$ttl_income	= mysqli_query($db, $qry_income) or die(mysqli_error($db));
$order = array();
foreach ( $ttl_income as $row){
	$order[] = $row;
}
mysqli_close($db);
print json_encode($order);
?>
