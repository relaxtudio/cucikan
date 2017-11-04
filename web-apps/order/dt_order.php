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
	0 => 'invoice',
	1 => 'tanggal',
	2 => ''
);
// total data tanpa search
$sql = "SELECT 
	id_order,
	id_usr_ord_fk,
	id_mbl_usr,
	invoice,
	lokasi,
	tanggal,
	jam,
	status,
	paket_cuci.nama_paket,
	paket_cuci.harga,
	jenis_pembayaran.tipe_pembayaran,
	jenis_pembayaran.keterangan_pembayaran,
	usr_mobil.nama_brand,
	usr_mobil.produk_mobil,
	usr_mobil.warna,
	usr_mobil.nopol,
	usr_detail.nama,
	usr_detail.telepon,
	usr.email
	FROM order_cuci
	INNER JOIN jenis_pembayaran ON order_cuci.pembayaran = jenis_pembayaran.id_pembayaran 
	INNER JOIN paket_cuci ON order_cuci.paket = paket_cuci.id_paket 
	INNER JOIN usr_mobil ON order_cuci.id_mbl_usr = usr_mobil.id_kendaraan 
	INNER JOIN usr_detail ON order_cuci.id_usr_ord_fk = usr_detail.id_user 
	INNER JOIN usr ON order_cuci.id_usr_ord_fk = usr.id 
	WHERE order_cuci.id_usr_ord_fk = '$usr' AND order_cuci.status = 'Order'";
$query=mysqli_query($db, $sql) or die(mysqli_error($db));
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  

if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter
	$sql.=" AND tanggal LIKE '%".$requestData['search']['value']."%' ";
	$query=mysqli_query($db, $sql) or die(mysqli_error($db));
	$totalFiltered = mysqli_num_rows($query);
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; // $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length.
	$query=mysqli_query($db, $sql) or die(mysqli_error($db));
	
} else {	
$sql = "SELECT 
	id_order,
	id_usr_ord_fk,
	id_mbl_usr,
	invoice,
	lokasi,
	tanggal,
	jam,
	status,
	paket_cuci.nama_paket,
	paket_cuci.harga,
	jenis_pembayaran.tipe_pembayaran,
	jenis_pembayaran.keterangan_pembayaran,
	usr_mobil.nama_brand,
	usr_mobil.produk_mobil,
	usr_mobil.warna,
	usr_mobil.nopol,
	usr_detail.nama,
	usr_detail.telepon,
	usr.email
	FROM order_cuci 
	INNER JOIN jenis_pembayaran ON order_cuci.pembayaran = jenis_pembayaran.id_pembayaran 
	INNER JOIN paket_cuci ON order_cuci.paket = paket_cuci.id_paket 
	INNER JOIN usr_mobil ON order_cuci.id_mbl_usr = usr_mobil.id_kendaraan 
	INNER JOIN usr_detail ON order_cuci.id_usr_ord_fk = usr_detail.id_user 
	INNER JOIN usr ON order_cuci.id_usr_ord_fk = usr.id 
	WHERE order_cuci.id_usr_ord_fk = '$usr' AND order_cuci.status = 'Order'";
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
$query=mysqli_query($db, $sql) or die(mysqli_error($db));
	
}
$data = array();
while( $row=mysqli_fetch_array($query) ) {	
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