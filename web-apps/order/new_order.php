<?php
require('../../process/config.php');
    if(empty($_SESSION['user']))
    {
        header("Location: ../../index.php");
        die("Redirecting to index.php");
    }
?>
<style>
button { background:#71CF62 }
button:disabled { background: #657362; }
</style>
<?php	

$usr	= $_SESSION['user']['id'];
$imel	= $_SESSION['user']['email'];
date_default_timezone_set('Asia/Jakarta');
$tanggal= date('Y-m-d');
$inv = 'INV/'.$usr.date('/ymd/is');

require_once('../../process/db.php');
$dtl	= "SELECT
		alamat,
		kota_kab,
		kecamatan
		FROM usr_detail
		WHERE id_user = '$usr'";
$dtl2	= mysqli_query($db, $dtl) or die(mysqli_error($db));
$pr		= mysqli_fetch_array($dtl2);
$pr1	= $pr['alamat'];
$pr2	= $pr['kota_kab'];
$pr3	= $pr['kecamatan'];
?>
<script>
$(function () {
	$('form').on('submit', function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: 'order/save_order.php',
			data: $('form').serialize(),
			success: function () {
				$('#content').load('home-content.php');
				alert('Data berhasil disimpan dan dikirim ke email. Mohon dicek.');
			}
		});
		console.log();
	});
});
</script>
<p style="font-size:16px;">Anda dapat membuat order untuk layanan kami dengan mengisi form dibawah ini. <br />
	Detail order anda akan dikirimkan ke email yang tertera pada form. Mohon dicek setelah data tersimpan.
</p>
<div id="panel-order" class="panel panel-default">
	<div class="panel-body">
	<legend align="center"><b>Form Order Cucikan</b></legend>
		<form id="addorder" class="form-horizontal" action="#" method="POST">
		<div class="row">
		<div class="col-md-6">
			<div class="form-group" style="display:none;">
				<label class="col-md-4 col-sm-5  control-label" for="id_usr_ord_fk" style="font-size:15px;color:black;">ID User</label>
				<div class="col-md-2 col-sm-3">
					<input id="id_usr_ord_fk" name="id_usr_ord_fk" type="text" placeholder="" maxlength="15" class="form-control input-md" value="<?php echo $usr;?>" readonly>
				</div>
			</div>
			<div class="form-group" style="display:none;">
				<label class="col-md-4 col-sm-5  control-label" for="email" style="font-size:15px;color:black;">email</label>
				<div class="col-md-6 col-sm-3">
					<input id="email" name="email" type="text" placeholder="" maxlength="15" class="form-control input-md" value="<?php echo $imel;?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 col-sm-5  control-label" for="invoice" style="font-size:15px;color:black;">Invoice</label>
				<div class="col-md-5 col-sm-6">
					<input id="invoice" name="invoice" type="text" placeholder="" class="form-control input-md" value="<?php echo $inv;?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 col-sm-5  control-label" for="mobil_user" style="font-size:15px;color:black;">Mobil Anda</label>
				<div class="col-md-6 col-sm-6">
					<select id="mobil_user" name="mobil_user" class="form-control input-md">
					<option disabled selected value>----Daftar Mobil Anda----</option>
					<?php
					$mbl_usr = "SELECT
						id_kendaraan,
						nama_brand,
						produk_mobil,
						warna,
						nama_pemilik
						FROM usr_mobil
						WHERE usr_mobil.id_user = '$usr'";
					$list_mbl = mysqli_query($db,$mbl_usr) or die(mysqli_error($db));
					while($x=mysqli_fetch_array($list_mbl)){?>
					<option value="<?php echo $x['id_kendaraan'];?>"><?php echo $x['nama_brand'];?>&nbsp;<?php echo $x['produk_mobil'];?>&nbsp;(<?php echo $x['warna'];?>)</option>
					<script>
					$(document).ready(function() {
						$("#mobil_user").on("change", function(){
							if($(this).val() == ""){
								$("#brand_mobil_ord").val("");
								$("#produk_mobil_ord").val("");
							}
							if($(this).val() == "<?php echo $x['id_kendaraan'];?>"){
								$("#brand_mobil_ord").val("<?php echo $x['nama_brand'];?>");
								$("#produk_mobil_ord").val("<?php echo $x['produk_mobil'];?>");
							}
						});
					});
					</script>
					<?php }	?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 col-sm-5 control-label" for="lokasi" style="font-size:15px;color:black;">Lokasi(*)</label>
				<div class="col-md-6 col-sm-6">
					<textarea id="lokasi" name="lokasi" placeholder="Lokasi tempat tinggal anda" class="form-control input-md" required><?php echo $pr1;?>, <?php echo $pr2;?>, <?php echo $pr3;?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 col-sm-5  control-label" for="tanggal" style="font-size:15px;color:black;">Tanggal(*)</label>
				<div class="col-md-5 col-sm-6">
					<input id="tanggal" name="tanggal" type="date" placeholder="" min="<?php echo $tanggal; ?>" class="form-control input-md" value="<?php echo date('Y-m-d'); ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 col-sm-5  control-label" for="email" style="font-size:15px;color:black;">Jam(*)</label>
				<div class="col-md-4 col-sm-5">
					<input id="jam" name="jam" type="text" placeholder="" class="form-control input-md" value="" required>
					<p id="ket-jam" style="font-size:13px; color: red;"><b></b></p>
					<script>
						$('#jam').timepicker({
							'step'		: '90',
							'timeFormat': 'H:i',
							'minTime'	: '06:00',
							'maxTime'	: '20:00'
						});
					</script>
					<script>
					var tanggal = '';
					var jam = '';
					$(this).change(function () {
						var limit = new Date().getTime() + (8 * 60 * 60 * 1000);
						limit = new Date(limit);
						tanggal = $('#tanggal')[0].value;
						// var input = new Date(tanggal + " 00:00:00");
							if ($('#jam')[0].value != '') {
								var jam = $('#jam')[0].value;
					   // input = input.getTime() + (jam * 60 * 60 * 1000);
					   // input = new Date(input);
								var input = new Date(tanggal + " " + jam + ":00");
							if (limit < input) {
								$('#ket-jam').text("");
								$('#simpan_order').prop('disabled', false);
							} else {
								$('#ket-jam').text("Pilihan waktu pelayanan minimal adalah h+8 jam dari waktu saat ini.");
								$('#simpan_order').prop('disabled', true);
							}

						}
					});
					 </script>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 col-sm-5  control-label" for="paket" style="font-size:15px;color:black;">Paket Layanan(*)</label>
				<div class="col-md-6 col-sm-6">
					<select id="paket" name="paket" class="form-control input-md" required>
					<option disabled selected value>----Daftar Paket Layanan----</option>
					<?php
					$qry_paket = "SELECT
						id_paket,
						nama_paket,
						harga,
						keterangan
						FROM paket_cuci";
					$list_paket = mysqli_query($db,$qry_paket) or die(mysqli_error($db));
					while($row=mysqli_fetch_array($list_paket)){?>
					<option value="<?php echo $row['id_paket'];?>"><?php echo $row['nama_paket'];?></option>
					<script>
					$(document).ready(function() {
						$("#paket").on("change",function(){
							if ($(this).val() == ""){
								$("#keterangan").val("");
								$("#harga").val("");
							}
							if($(this).val() == "<?php echo $row['id_paket'];?>"){
								$("#keterangan").val("<?php echo $row['keterangan'];?>");
								$("#harga").val("<?php echo $row['harga'];?>");
							}
						});
					});
					</script>
					<?php }	?>
					</select>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-4 col-sm-5 control-label" for="keterangan" style="font-size:15px;color:black;">Keterangan Layanan</label>
				<div class="col-md-6 col-sm-6">
					<textarea id="keterangan" name="keterangan" placeholder="" class="form-control input-md" style="height: 150px;" readonly></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 col-sm-5  control-label" for="harga" style="font-size:15px;color:black;">Total Harga (IDR)</label>
				<div class="col-md-5 col-sm-6">
					<input id="harga" name="harga" type="text" placeholder="" class="form-control input-md" value="" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 col-sm-5  control-label" for="pembayaran" style="font-size:15px;color:black;">Pembayaran</label>
				<div class="col-md-5 col-sm-6">
					<select id="pembayaran" name="pembayaran" class="form-control input-md">
						<?php
						$qry_pay = "SELECT
							id_pembayaran,
							tipe_pembayaran,
							keterangan_pembayaran
							FROM jenis_pembayaran";
						$list_pay = mysqli_query($db, $qry_pay) or die(mysqli_error($db));
						while($row=mysqli_fetch_array($list_pay)){?>
						<option value="<?php echo $row['id_pembayaran'];?>"><?php echo $row['tipe_pembayaran'];?></option>
						<?php }	?>
						<script>
						$(function(){
							$("#pembayaran option[value=2]").prop("disabled",true);
						});
						</script>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 col-sm-5 control-label" for="simpan_order"></label>
				<div class="col-md-6">
					<button id="simpan_order" name="simpan_order" class="btn btn-outline btn-xl btn-block"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <b>Order Sekarang</b></button>
				</div>
			</div>
		</div>
		</div>
		</form>
	</div>
</div>
