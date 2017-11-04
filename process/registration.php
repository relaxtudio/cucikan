<?php
require("config.php"); 
	if(!empty($_POST)) 
    { 
        // Ensure that the user fills out fields 
        if(empty($_POST['username'])) 
        { die("Masukkan username anda"); } 
        if(empty($_POST['password'])) 
        { die("Masukkan password anda"); }
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
        { die("Format e-mail anda tidak valid!"); }
        if(empty($_POST['nama'])) 
        { die("Masukkan nama anda"); }
		if(empty($_POST['gender'])) 
        { die("Pilih jenis kelamin diri anda"); }
		if(empty($_POST['alamat'])) 
        { die("Masukkan alamat anda"); }
		if(empty($_POST['kota_kab'])) 
        { die("Masukkan kota/kabupaten tempat tinggal anda"); }
		if(empty($_POST['kecamatan'])) 
        { die("Masukkan kecamatan tempat tinggal anda"); }		 
		if(empty($_POST['telepon'])) 
        { die("Masukkan nomor telepon anda"); }
		
		// Check if the username is already taken
        $query = " 
            SELECT 
                1 
            FROM usr 
            WHERE 
                username = :username 
        "; 
        $query_params = array( ':username' => $_POST['username'] ); 
        try { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex){ die("Gagal menjalankan query: " . $ex->getMessage()); } 
        $row = $stmt->fetch(); 
        if($row){ die('<script type="text/javascript">alert("Username telah digunakan! Silahkan gunakan username yang berbeda.");location.replace("../index.php")</script>'); }
	    $query = " 
            SELECT 
                1 
            FROM usr 
            WHERE 
                email = :email 
        "; 
        $query_params = array( 
            ':email' => $_POST['email'] 
        ); 
        try { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex){ die("Query gagal dijalankan: " . $ex->getMessage());} 
        $row = $stmt->fetch(); 
        if($row){ 
		die(('<script type="text/javascript">
				alert("Email telah digunakan! Silahkan gunakan email yang berbeda.")
				;location.replace("../index.php")</script>'));} 
         
        // Add row to database 
        $query = " 
            INSERT INTO usr ( 
                username, 
                password, 
                salt,
				email,
				usrcred
                ) VALUES ( 
                :username, 
                :password, 
                :salt,
				:email,
				:usrcred
                ) 
        ";
		$query2 = "
			INSERT INTO usr_detail (
				nama,
				gender,
				alamat,
				kota_kab,
				kecamatan,
				telepon
				) VALUES (
				:nama,
				:gender,
				:alamat,
				:kota_kab,
				:kecamatan,
				:telepon
			)
		";
		
        // Security measures
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
        $password = hash('sha256', $_POST['password'] . $salt); 
        for($round = 0; $round < 65536; $round++){ $password = hash('sha256', $password . $salt); } 
        $query_params = array( 
            ':username' => $_POST['username'], 
            ':password' => $password, 
            ':salt' => $salt,
			':email' => $_POST['email'],
			':usrcred' => 2
			);
		$query_params2 = array(
			':nama' => $_POST['nama'],
			':gender' => $_POST['gender'],
			':alamat' => $_POST['alamat'],
			':kota_kab' => $_POST['kota_kab'],
			':kecamatan' => $_POST['kecamatan'],
			':telepon' => $_POST['telepon']
			);
        try {  
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        }	
        catch(PDOException $ex){ die("Query gagal dijalankan: " . $ex->getMessage()); } 
		try {  
            $stmt = $db->prepare($query2); 
            $result2 = $stmt->execute($query_params2); 
        }
		catch(PDOException $ex){ die("Query gagal dijalankan: " . $ex->getMessage()); }
	} 
?>
<script type="text/javascript"> alert("Selamat! Akun anda telah terdaftar!");</script>
<meta http-equiv="refresh" content="0; url=../index.php#cta">
	