<!DOCTYPE html>
<html lang="en">
<head>
	<?php include('../hdr_ftr/lgn_header.html');?>
	<style>
	body{
		background: url(../assets/img/bg-pattern.png),#3E41D8;
		background: url(../assets/img/bg-pattern.png),-webkit-linear-gradient(to left,#9C3DCC,#7DFCFC);
		background: url(../assets/img/bg-pattern.png),linear-gradient(to left,#3E41D8,#9C3DCC);
	}
	.panel{
		position: absolute;
		top: calc(50% - 200px);
		left: calc(50% - 145px);
		height: auto;
		width: auto;
		min-width: 265px;
	}
	</style>
	
</head>
<body>
	<div class="container">
		<div class="panel panel-default" style="background:transparent;">
		<div class="panel-body">
		<h4 align="center" style="background:white;"><img src="../assets/img/logo-vici1.png" style="width:165px;height:50px;"></h4>
			<br />
			<form id="res_pass" class="form-horizontal" method="POST" action="../process/respass.php">
				<div class="form-group">
					<label class="col-md-4 control label" for="username" style="font-size:16px;color:white;" value="" required>Username</label>
					<div class="col-md-8">	
						<input id="username" name="username" type="text" class="form-control input-md" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control label" for="email" style="font-size:16px;color:white;" value="" required>Email</label>
					<div class="col-md-8">	
						<input id="email" name="email" type="text" class="form-control input-md" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-0 control-label" for="respass"></label>
					<div class="col-md-12">
						<button type="submit" class="btn btn-outline btn-xl btn-block" style="background-color:transparent;color:white;" value="respass">Reset Password</button>
					</div>
				</div>
			</form>
			<p align="center" style="font-size:15px;color:white;"><b>Kembali ke halaman login? <u><a href="../pages/apps-lgn">Klik disini</a></u></b></p>
		</div>
		</div>
	</div>
	<?php include('../hdr_ftr/lgn_footer.html');?>
	
</body>
</html>