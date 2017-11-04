<?php
require_once('../../process/db.php');

$qry_ord = "SELECT
		tanggal,
		SUM(paket_cuci.harga) AS totalduit 
		FROM order_cuci 
		INNER JOIN paket_cuci 
		ON order_cuci.paket = paket_cuci.id_paket 
		WHERE YEARWEEK(tanggal) = YEARWEEK(NOW())
		AND status = 'Completed'
		GROUP BY tanggal";
$result = mysqli_query($db, $qry_ord) or die(mysqli_error($db));
$data = array();
foreach ( $result as $row){
	$data[] = $row;
}
mysqli_close($db);
print json_encode($data);
?>