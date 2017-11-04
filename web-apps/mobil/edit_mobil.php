<?php
    require('../../process/config.php');
    if(empty($_SESSION['user'])) 
    {
        header('Location: ../../index.php');
        die('Redirecting to index.php'); 
    }
?>
<?php include('../../process/db.php'); ?>
<?php include('dt_edit.php');?>
<script>
$(function () {
	$('form').on('submit', function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: 'mobil/upd_mobil.php',
			data: $('form').serialize(),
			success: function () {
				$('#content').load('home-content.php');
				alert('Data berhasil diupdate');
			}
		});
	});
});
</script>
<div id="panel-edit-mobil" class="panel panel-default">
	<div class="panel-body">
	<legend align="center">Form Edit Data Mobil</legend>
		<form id="updatemobil" class="form-horizontal" action="update_mobil.php" method="POST">	
			<div class="form-group" style="display:none">
				<label class="col-md-5 col-sm-5 control-label" for="id_kendaraan" style="font-size:15px;color:black;">ID Kendaraan</label>
				<div class="col-md-2 col-sm-3">
					<input id="id_kendaraan" name="id_kendaraan" type="text" placeholder="" maxlength="15" class="form-control input-md" value="<?php echo $a;?>" readonly>
				</div>
			</div>
			<div class="form-group" style="display:none;">
				<label class="col-md-5 col-sm-5 control-label" for="id_user" style="font-size:15px;color:black;">ID User</label>
				<div class="col-md-2 col-sm-3">
					<input id="id_user" name="id_user" type="text" placeholder="" maxlength="15" class="form-control input-md" value="<?php echo $b;?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-5 col-sm-5  control-label" for="brand" style="font-size:15px;color:black;">Merk Mobil(*)</label>
				<div class="col-md-3 col-sm-7">
					<input type="text" id="brand" name="brand" value="<?php echo $c;?>" class="form-control input-md" required>
					<script>
					$("#brand").autocomplete({
						source: "mobil/list_brand.php",
						minLength: 2
					});
					</script>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-5 col-sm-5 control-label" for="produk_mobil" style="font-size:15px;color:black;">Nama Produk(*)</label>
				<div class="col-md-3 col-sm-7">
					<input id="produk_mobil" name="produk_mobil" type="text" placeholder="" class="form-control input-md" value="<?php echo $d;?>" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-5 col-sm-5 control-label" for="tahun" style="font-size:15px;color:black;">Tahun(*)</label>
				<div class="col-md-2 col-sm-5">
					<input id="tahun" name="tahun" type="number" placeholder="" class="form-control input-md" value="<?php echo $e?>" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-5 col-sm-5 control-label" for="warna" style="font-size:15px;color:black;">Warna(*)</label>
				<div class="col-md-3 col-sm-7">
					<input id="warna" name="warna" type="text" placeholder="" class="form-control input-md" value="<?php echo $f?>" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-5 col-sm-5 control-label" for="nama_pemilik" style="font-size:15px;color:black;">Nama Pemilik(*)</label>
				<div class="col-md-3 col-sm-7">
					<input id="nama_pemilik" name="nama_pemilik" type="text" placeholder="" class="form-control input-md" value="<?php echo $g;?>" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-5 col-sm-5 control-label" for="nopol" style="font-size:15px;color:black;">Plat Nomor(*)</label>
				<div class="col-md-2 col-sm-6">
					<input id="nopol" name="nopol" type="text" placeholder="" maxlength="10" class="form-control input-md" value="<?php echo $h;?>" required>
				</div>
			</div>
			<p align="center">(*) Harap diisi dengan data sesuai dengan yang tertera di STNK</p>
			<div class="form-group">
				<label class="col-md-4 col-sm-4 control-label" for="update_mobil"></label>
				<div class="col-md-4">
					<button id="update_mobil" name="update_mobil" onclick="return confirm('Anda yakin ingin melakukan update data mobil ini?');" class="btn btn-outline btn-xl btn-block" style="background-color:#6AF186;color:black;"><b>Update Data Mobil</b></button>
				</div>
			</div>
		</form>
	</div>
</div>