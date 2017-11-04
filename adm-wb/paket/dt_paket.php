<?php
require_once('../../process/db.php');
$requestData= $_REQUEST;
$columns	= array(
	0 => 'id_paket',
	1 => 'nama_paket',
	2 => 'harga',
	3 => ''
);	
$sql	= "SELECT
		id_paket,
		nama_paket,
		harga,
		keterangan
		FROM paket_cuci";
$query = mysqli_query($db, $sql) or die(mysqli_error($db));
$totalData= mysqli_num_rows($query);
$totalFiltered = $totalData;

if(!empty($requestData['search']['value'])){

	$sql.=" WHERE id_paket LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR nama_paket LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR harga LIKE '%".$requestData['search']['value']."%' ";
	$query=mysqli_query($db, $sql) or die(mysqli_error($db));
	$totalFiltered = mysqli_num_rows($query);
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	$query=mysqli_query($db, $sql) or die(mysqli_error($db));
}else{
$sql	= "SELECT
		id_paket,
		nama_paket,
		harga,
		keterangan
		FROM paket_cuci";
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	$query=mysqli_query($db, $sql) or die(mysqli_error($db));
}
$data= array();
while($row=mysqli_fetch_array($query)){
	foreach ($query as $row){	
		$data[]=$row;
	}
}
$json_data = array(
	"draw"            => intval( $requestData['draw'] ),  //client side data tables draw number
	"recordsTotal"    => intval( $totalData ), 
	"recordsFiltered" => intval( $totalFiltered ),
	"data"            => $data   // total data array
);
mysqli_close($db);
echo json_encode($json_data);
?>