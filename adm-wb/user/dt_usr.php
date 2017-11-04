<?php
require_once('../../process/db.php');
$requestData= $_REQUEST;
$columns	= array(
	0 => 'id',
	1 => 'username',
	2 => 'email',
	3 => '',
	4 => ''
);

$sql	= "SELECT
		usr.id,
		usr.username,
		usr.email,
		usr.usrcred,
		usr_detail.nama,
		usr_detail.gender,
		usr_detail.alamat,
		usr_detail.kota_kab,
		usr_detail.kecamatan,
		usr_detail.telepon
		FROM usr 
		INNER JOIN usr_detail
		ON usr.id = usr_detail.id_user
		WHERE usr.usrcred != '1'
		";
$query = mysqli_query($db, $sql) or die(mysqli_error($db));
$totalData= mysqli_num_rows($query);
$totalFiltered = $totalData;

if(!empty($requestData['search']['value'])){

	$sql.=" AND id LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR username LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR email LIKE '%".$requestData['search']['value']."%' ";
	$query=mysqli_query($db, $sql) or die(mysqli_error($db));
	$totalFiltered = mysqli_num_rows($query);
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	$query=mysqli_query($db, $sql) or die(mysqli_error($db));
}else{
	$sql = "SELECT usr.id, usr.username, usr.email, usr.usrcred, usr_detail.nama, usr_detail.gender, usr_detail.alamat, usr_detail.kota_kab, usr_detail.kecamatan, usr_detail.telepon FROM usr INNER JOIN usr_detail ON usr.id = usr_detail.id_user WHERE usr.usrcred != '1'";
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