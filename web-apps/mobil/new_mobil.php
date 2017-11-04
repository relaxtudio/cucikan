<?php
    require("../../process/config.php");
    if(empty($_SESSION['user']))
    {
        header("Location: ../../index.php");
        die("Redirecting to index.php");
    }
?>
<?php include('../../process/db.php'); ?>
<script>
$(function () {
	$('form').on('submit', function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: 'mobil/save_mobil.php',
			data: $('form').serialize(),
			success: function () {
				$('#content').load('home-content.php');
				alert('Data berhasil disimpan');
			}
		});
		console.log();
	});
});
</script>
	<p>Anda dapat menambahkan informasi mengenai mobil anda pada form dibawah ini</p>
	<div id="panel-mobil" class="panel panel-default">
		<div class="panel-body">
			<legend align="center"><b>Form Info Mobil</b></legend>
			<form id="addmobil" class="form-horizontal" action="#" method="POST">
				<div class="form-group" style="display:none;">
					<label class="col-md-5 col-sm-5  control-label" for="id_user" style="font-size:15px;color:black;">ID User</label>
					<div class="col-md-2 col-sm-3">
						<input id="id_user" name="id_user" type="text" placeholder="" maxlength="15" class="form-control input-md" value="<?php echo $_SESSION['user']['id'];?>" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-5 col-sm-5  control-label" for="brand" style="font-size:15px;color:black;">Merk Mobil(*)</label>
					<div class="col-md-3 col-sm-7">
						<input type="text" id="brand" name="brand" class="form-control input-md" required>
						<script>
						$("#brand").autocomplete({
							source: "mobil/list_brand.php",
							minLength: 2
						});
						</script>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-5 col-sm-5  control-label" for="produk_mobil" style="font-size:15px;color:black;">Nama Produk(*)</label>
					<div class="col-md-3 col-sm-7">
						<input id="produk_mobil" name="produk_mobil" type="text" placeholder="" class="form-control input-md" value="" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-5 col-sm-5  control-label" for="tahun" style="font-size:15px;color:black;">Tahun(*)</label>
					<div class="col-md-2 col-sm-5">
						<input id="tahun" name="tahun" type="number" placeholder="" class="form-control input-md" value="" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-5 col-sm-5  control-label" for="warna" style="font-size:15px;color:black;">Warna(*)</label>
					<div class="col-md-3 col-sm-7">
						<input id="warna" name="warna" type="text" placeholder="" class="form-control input-md" value="" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-5 col-sm-5  control-label" for="nama_pemilik" style="font-size:15px;color:black;">Nama Pemilik(*)</label>
					<div class="col-md-3 col-sm-7">
						<input id="nama_pemilik" name="nama_pemilik" type="text" placeholder="" class="form-control input-md" value="" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-5 col-sm-5  control-label" for="nopol" style="font-size:15px;color:black;">Plat Nomor(*)</label>
					<div class="col-md-2 col-sm-6">
						<input id="nopol" name="nopol" type="text" placeholder="" maxlength="10" class="form-control input-md" value="" required>
					</div>
				</div>
				<p align="center">(*) Harap diisi dengan data sesuai dengan yang tertera di STNK</p>
				<div class="form-group">
					<label class="col-md-4 col-sm-4 control-label" for="simpan_mobil"></label>
					<div class="col-md-4">
						<button id="simpan_mobil" name="simpan_mobil" class="btn btn-outline btn-xl btn-block" style="background-color:#6AF186;color:black;"><b>Simpan Data Mobil</b></button>
					</div>
				</div>
			</form>
		</div>
	</div>
