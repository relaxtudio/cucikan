<?php include('dt_edit_profile.php');?>
<script>
$(function () {
	$('form').on('submit', function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: 'profile/upd_profile.php',
			data: $('form').serialize(),
			success: function () {
				$('#content').load('profile/edit_profile_form.php');
				alert('Data berhasil diupdate');
			}
		});
	});
});
</script>
<p>Silahkan edit informasi terkait akun anda pada form berikut ini.</p>
<div id="panel-profile" class="panel panel-default">
	<div class="panel-body">
	<legend align="center"><b>Form Edit Profile</b></legend>
	<form id="edit_profile" class="form-horizontal" action="#" method="POST">
		<div class="form-group" style="display:none;">
			<label class="col-md-5 control-label" for="id" style="font-size:13px;">ID</label>
			<div class="col-md-2">
				<input id="id" name="id" type="text" placeholder="" maxlength="15" class="form-control input-md" value="<?php echo $pr1;?>" required readonly>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-5 control-label" for="username" style="font-size:13px;">USERNAME</label>
			<div class="col-md-3">
				<input id="username" name="username" type="text" placeholder="Username anda" maxlength="15" class="form-control input-md" value="<?php echo $pr2;?>" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-5 control-label" for="password" style="font-size:13px;">PASSWORD</label>
			<div class="col-md-3">
				<input id="password" name="password" type="password" placeholder="Password anda" class="form-control input-md" value="" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-5 control-label" for="email" style="font-size:13px;">EMAIL</label>
			<div class="col-md-3">
				<input id="email" name="email" type="text" placeholder="Email anda" class="form-control input-md" value="<?php echo $pr3?>" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-5 control-label" for="nama" style="font-size:13px;">NAMA</label>
			<div class="col-md-3">
				<input id="nama" name="nama" type="text" placeholder="Nama anda" class="form-control input-md" value="<?php echo $pr4?>" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-5 control-label" for="gender" style="font-size:13px;">JENIS KELAMIN</label>
			<div class="col-md-2" style="color:black;">
			<div class="radio">
				<label for="gender-0">
				<input type="radio" name="gender" id="gender-0" value="pria" <?php if ($pr5=="pria") {echo "checked=\"checked\"";}?> required>
				Pria
				</label>
			</div>
			<div class="radio">
				<label for="gender-1">
				<input type="radio" name="gender" id="gender-1" value="wanita" <?php if ($pr5=="wanita") {echo "checked=\"checked\"";}?> required>
				Wanita
				</label>
			</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-5 control-label" for="alamat" style="font-size:13px;">ALAMAT</label>
			<div class="col-md-4">
				<textarea id="alamat" name="alamat" placeholder="Alamat tempat tinggal anda" class="form-control input-md" required><?php echo $pr6;?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-5 control-label" for="kota_kab" style="font-size:13px;">KOTA/KABUPATEN</label>
			<div class="col-md-3">
				<input id="kota_kab" name="kota_kab" type="text" placeholder="Kota tempat tinggal" class="form-control input-md" value="<?php echo $pr7;?>" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-5 control-label" for="kecamatan" style="font-size:13px;">KECAMATAN</label>
			<div class="col-md-3">
				<input id="kecamatan" name="kecamatan" type="text" placeholder="Kecamatan rumah anda" class="form-control input-md" value="<?php echo $pr8; ?>" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-5 control-label" for="telepon" style="font-size:13px;">TELEPON</label>
			<div class="col-md-2">
				<input id="telepon" name="telepon" type="text" placeholder="Nomor telepon anda" class="form-control input-md" value="<?php echo $pr9;?>" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-5 control-label" for="update_profile"></label>
			<div class="col-md-4">
				<button id="update_profile" class="btn btn-primary btn-outline btn-xl btn-block"><b>Update Me!</b></button>
			</div>
		</div>
	</form>
	</div>
</div>