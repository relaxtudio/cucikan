<?php
require('../../process/config.php');
    if(empty($_SESSION['user'])) 
    {
        header('Location: ../../index.php');
        die("Redirecting to index.php"); 
    }
require_once('../../process/db.php');
$requestData= $_REQUEST;
$usr	= $_SESSION['user']['id'];
$columns = array( 
// datatable column index  => database nama kolom
	0 => 'nopol',
	1 => 'produk_mobil',
	2 => 'warna',
	3 => ''
);
// total data tanpa search
$sql = "SELECT 
	id_kendaraan,
	id_user,
	nama_brand, 
	produk_mobil,
	tahun,
	warna,
	nama_pemilik,
	nopol";
$sql.="   FROM usr_mobil WHERE id_user = '$usr'";
$query=mysqli_query($db, $sql) or die("dt_mobil.php: get mobil");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  

	$sql = "SELECT id_kendaraan, id_user, nama_brand, produk_mobil, tahun, warna, nama_pemilik, nopol";
	$sql.=" FROM usr_mobil WHERE id_user = '$usr'";
if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter
	$sql.=" AND nopol LIKE '%".$requestData['search']['value']."%' ";    // $requestData['search']['value'] merupakan parameter untuk search
	$query=mysqli_query($db, $sql) or die("dt_mobil.php: get mobil");
	$totalFiltered = mysqli_num_rows($query);
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; // $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length.
	$query=mysqli_query($db, $sql) or die("dt_mobil.php: get mobil");
	
} else {	
	$sql = "SELECT id_kendaraan, id_user, nama_brand, produk_mobil, tahun, warna, nama_pemilik, nopol";
	$sql.=" FROM usr_mobil WHERE id_user = '$usr'";
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	$query=mysqli_query($db, $sql) or die("dt_mobil.php: get mobil");
	
}
$data = array();
while( $row=mysqli_fetch_array($query) ) {
	//$functions  = '<a class="btn btn-info" href="#" title="Detail">
	//				<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> </a>&nbsp;';
    //$functions .= '<a id="'.$row['id_kendaraan'].'" onclick="return konfirmasi()" class="btn btn-danger" href="#" title="Hapus mobil">
	//				<span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </a>';
	
	foreach ($query as $row){
		$data[] = $row;
	}
}
$json_data = array(
			"draw"            => intval( $requestData['draw'] ),  //client side data tables draw number
			"recordsTotal"    => intval( $totalData ), 
			"recordsFiltered" => intval( $totalFiltered ),
			"data"            => $data   // total data array
			);
echo json_encode($json_data);
$json_string = json_encode($json_data, JSON_PRETTY_PRINT);
?>
