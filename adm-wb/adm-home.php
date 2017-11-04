<?php
    require("../process/config.php");
    if(empty($_SESSION['user']))
    {
        header("Location: ../index.php");
        die("Redirecting to index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
	include('../process/db.php');
	include('../hdr_ftr/adm_header.html');
?>
</head>
<body>
<div id="page">
	<div class="header">
	<?php include('../navbar/adm_nav.html');?>
	</div>
	<br />
	<div class="content">
		<div class="container">
			<div id="adm-content">
			<?php include('dashboard/dashboard.php');?>
			</div>
		</div>
	</div>
<?php include('../hdr_ftr/subf_script_footer.html');?>
</div>
</body>
</html>
