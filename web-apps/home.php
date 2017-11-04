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
		include('../hdr_ftr/wa_header.html');
		include('../process/db.php');
	?>
	<style>
	.btn, .panel {border-radius: 0 !important;}
	</style>
</head>
<body>
<div id="page">
	<div class="header">
	<?php include('../navbar/wa_nav.html');?>		
	</div>
	<br></br>
	<div class="container">
		<div id="content">
			<?php include('home-content.php');?>
		</div>
	</div>
		<?php include('../hdr_ftr/subf_script_footer.html');?>
</div>
</body>
</html>