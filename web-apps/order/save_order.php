<?php
require_once('../../process/db.php');

if(!empty($_POST)){
$ord1	= $_POST['id_usr_ord_fk'];
$ord2	= $_POST['mobil_user'];
$ord3	= $_POST['invoice'];
$ord4	= $_POST['lokasi'];
$ord5	= $_POST['tanggal'];
$ord6	= $_POST['jam'];
$ord7	= $_POST['paket'];
$ord8	= $_POST['pembayaran'];
$ord9	= 'Order';
$imel	= $_POST['email'];

	$sql	= "INSERT INTO order_cuci(
	`id_usr_ord_fk`,
	`id_mbl_usr`,
	`invoice`,
	`lokasi`,
	`tanggal`,
	`jam`,
	`paket`,
	`pembayaran`,
	`status`)VALUES(
	'$ord1',
	'$ord2',
	'$ord3',
	'$ord4',
	'$ord5',
	'$ord6',
	'$ord7',
	'$ord8',
	'$ord9')";
mysqli_query($db, $sql) or die(mysqli_error($db));

$mbl	= "SELECT nama_brand, produk_mobil
		FROM usr_mobil
		WHERE id_kendaraan = '$ord2'";
$m		= mysqli_query($db, $mbl) or die(mysqli_error($db));
$n		= mysqli_fetch_array($m);
$nm_brnd= $n['nama_brand'];
$nm_mbl	= $n['produk_mobil'];

$uid	= "SELECT
		nama,
		telepon
		FROM usr_detail
		WHERE id_user = '$ord1'";
$u		= mysqli_query($db, $uid) or die(mysqli_error($db));
$v		= mysqli_fetch_array($u);
$unama	= $v['nama'];
$utlp	= $v['telepon'];

$adm_i	= "SELECT email FROM usr WHERE usrcred=1";
$qr		= mysqli_query($db, $adm_i) or die(mysqli_error($db));
$rm		= mysqli_fetch_array($qr);
$adm_m	= $rm['email'];

$byr	= "SELECT id_pembayaran, tipe_pembayaran, keterangan_pembayaran
		FROM jenis_pembayaran
		WHERE id_pembayaran = '$ord8'";
$c		= mysqli_query($db, $byr) or die(mysqli_error($db));
$d		= mysqli_fetch_array($c);
$tp_byr	= $d['tipe_pembayaran'];

$pkt	= "SELECT nama_paket, harga
		FROM paket_cuci
		WHERE id_paket = '$ord7'";
$b		= mysqli_query($db, $pkt) or die(mysqli_error($db));
$p		= mysqli_fetch_array($b);
$nm_pkt	= $p['nama_paket'];
$hrg	= $p['harga'];

$new_tgl = date("d-m-Y", strtotime($ord5));

$to = $imel;
$subject = "Invoice Order Cucikan " . $ord3;

$message = "Dear customer,\r\n";
$message .="Terima kasih telah melakukan order layanan kami. Berikut kami informasikan kembali detail pemesanan anda.\r\n";
$message .="\r\n";
$message .="ORDER INVOICE " . $ord3 . "\r\n";
$message .="\r\n";
$message .="Mobil : " . $nm_brnd . " " . $nm_mbl ."\r\n";
$message .="Nama Pemesan : " . $unama . "\r\n";
$message .="Email : " . $imel . "\r\n";
$message .="Telepon : " . $utlp . "\r\n";
$message .="Lokasi : " . $ord4 . "\r\n";
$message .="Tanggal : " . $new_tgl . "\r\n";
$message .="Jam : " . $ord6 . "\r\n";
$message .="Paket Layanan : " . $nm_pkt . "\r\n";
$message .="Harga : IDR " . $hrg . ",-\r\n";
$message .="Pembayaran : " . $tp_byr . "\r\n";
$message .="\r\n";
$message .="\r\n";
$message .="Terus gunakan layanan kami untuk menjaga kebersihan mobil anda.\r\n";
$message .="Salam, Cucikan. \r\n";
$message = wordwrap($message,70);

$headers = "From: Cucikan " . $adm_m . "\r\n";
$headers .= "Reply-To: " . $adm_m . "\r\n";
$headers .= "Return-Path: " . $adm_m . "\r\n";
$headers .= "CC:" . $imel . "\r\n";
$headers .= "BCC:" . $imel . "\r\n";

mail($to,$subject,$message,$headers);

//admin section
$to2 = $adm_m;
$subject2 = "Notifikasi Order Baru";

$message2 = "Hai, ada order baru dari customer. Berikut info detailnya.\r\n";
$message2 .= "\r\n";
$message2 .="ORDER INVOICE " . $ord3 . "\r\n";
$message2 .="\r\n";
$message2 .="Mobil : " . $nm_brnd . " " . $nm_mbl ."\r\n";
$message2 .="Nama Pemesan : " . $unama . "\r\n";
$message2 .="Email : " . $imel . "\r\n";
$message2 .="Telepon : " . $utlp . "\r\n";
$message2 .="Lokasi : " . $ord4 . "\r\n";
$message2 .="Tanggal : " . $new_tgl . "\r\n";
$message2 .="Jam : " . $ord6 . "\r\n";
$message2 .="Paket Layanan : " . $nm_pkt . "\r\n";
$message2 .="Harga : IDR " . $hrg . ",-\r\n";
$message2 .="Pembayaran : " . $tp_byr . "\r\n";
$message2 .="\r\n";
$message2 = wordwrap($message2,70);

$headers2 = "From: Cucikan " . $adm_m . "\r\n";
$headers2 .= "Reply-To: " . $adm_m . "\r\n";
$headers2 .= "Return-Path: " . $adm_m . "\r\n";
$headers2 .= "CC:" . $adm_m . "\r\n";
$headers2 .= "BCC:" . $adm_m . "\r\n";

mail($to2,$subject2,$message2,$headers2);

mysqli_close($db);
}
?>