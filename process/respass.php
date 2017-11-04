<?php 
require("../process/config.php"); 
if(!empty($_POST)){
	$query = "SELECT 
		usr.id, 
		usr.username,
		usr.password,
		usr.salt,
		usr.email
		FROM usr
		WHERE username = :username
		AND email = :email 
		";
	$query_params = array(
		':username' => $_POST['username'],
		':email' => $_POST['email']
	);
	try{
		$stmt	= $db->prepare($query);
		$result	= $stmt->execute($query_params);
	}
	catch(PDOException $ex){die("Gagal menjalankan query: " . $ex->getMessage());}
	$respass_ok = false;
	$row = $stmt->fetch();
	if(!$row){
		die('<script type="text/javascript">alert("Maaf, akun tersebut belum terdaftar pada sistem!");location.replace("../pages/res_pass.php")</script>'); 
	}
	if($row){
		$cek_username	= $_POST['username'];
		$cek_email		= $_POST['email'];
		if(($cek_username === $row['username']) && ($cek_email === $row['email'])){
			$respass_ok = true;
		}
	}
	
	if($respass_ok){
		$newpass = dechex(mt_rand(0, 2147483647));
		$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
        $password = hash('sha256', $newpass . $salt); 
        for($round = 0; $round < 65536; $round++){ $password = hash('sha256', $password . $salt); }
		
		$query = "UPDATE usr SET
		password		= :password,
		salt			= :salt
		WHERE username	= :username
		AND email		= :email
		";
		$query_params	= array(
		':username'		=> $_POST['username'],
		':email'		=> $_POST['email'],
		':password'		=> $password,
		':salt'			=> $salt
		);
		try{
			$stmt = $db->prepare($query);
			$result	= $stmt->execute($query_params);
		}
		catch(PDOException $ex){die("Query gagal dijalankan: " . $ex->getMessage());}
	
	$usrnm	= $_POST['username'];
	$em		= $_POST['email'];
	$to		= $em;
	$subject = "Cucikan  - Reset Password Akun";
	
	$message ="Dear customer,\r\n";
	$message .="Anda telah melakukan request untuk reset password akun anda.\r\n";
	$message .="\r\n";
	$message .="Berikut keterangan akun anda dengan password yang baru.\r\n";
	$message .="\r\n";
	$message .="Username : " . $usrnm ."\r\n";
	$message .="Password : " . $newpass . "\r\n";
	$message .="\r\n";
	$message .="Silahkan login menggunakan password tersebut dan segera lakukan perubahan password anda. Terima kasih.\r\n";
	$message .="Salam, Cucikan. \r\n";

	$headers = "From: Cucikan <admin@cucikan.com>\r\n";
	$headers .= "Reply-To: admin@cucikan.com\r\n";
	$headers .= "Return-Path: admin@cucikan.com\r\n";
	$headers .= "CC:" . $em . "\r\n";
	$headers .= "BCC:" . $em . "\r\n";

	mail($to,$subject,$message,$headers);
	
	echo "<script>alert('Password anda berhasil direset, silahkan cek email!');window.location.replace('../pages/apps-lgn.php')</script>";
	}
}
?>