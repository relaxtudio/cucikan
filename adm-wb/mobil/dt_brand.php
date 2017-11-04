<?php
require_once('../../process/db.php');
$requestData= $_REQUEST;
$columns	= array(
	0 => 'id_brand_mobil',
	1 => 'nama_brand_mobil',
	2 => ''
);	
$sql	= "SELECT
		id_brand_mobil,
		nama_brand_mobil
		FROM brand_mobil
		";
$query = mysqli_query($db, $sql) or die(mysqli_error($db));
$totalData= mysqli_num_rows($query);
$totalFiltered = $totalData;

if(!empty($requestData['search']['value'])){

	$sql.=" WHERE id_brand_mobil LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR nama_brand_mobil LIKE '%".$requestData['search']['value']."%' ";
	$query=mysqli_query($db, $sql) or die(mysqli_error($db));
	$totalFiltered = mysqli_num_rows($query);
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	$query=mysqli_query($db, $sql) or die(mysqli_error($db));
}else{
$sql = "SELECT
		id_brand_mobil,
		nama_brand_mobil
		FROM brand_mobil
		";
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