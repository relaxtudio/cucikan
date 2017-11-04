<?php 
    require("../process/config.php"); 
    $submitted_username = ''; 
    if(!empty($_POST)){ 
        $query = " 
            SELECT 
                usr.id, 
                usr.username,
				usr.password,
				usr.salt,
				usr.email,
				usr.usrcred,
				usr_detail.nama,
				usr_detail.alamat,
				usr_detail.kota_kab
            FROM usr
			INNER JOIN usr_detail
			ON usr.id = usr_detail.id_user
            WHERE 
                username = :username
        "; 
        $query_params = array( 
            ':username' => $_POST['username'] 
        ); 
         
        try{ 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 
        $login_ok = false; 
        $row = $stmt->fetch(); 
        if($row){ 
            $check_password = hash('sha256', $_POST['password'] . $row['salt']); 
            for($round = 0; $round < 65536; $round++){
                $check_password = hash('sha256', $check_password . $row['salt']);
            } 
            if($check_password === $row['password']){
                $login_ok = true;
            } 
        } 
		if($login_ok and $row['usrcred']==0){ 
            unset($row['salt']); 
            unset($row['password']); 
            $_SESSION['user'] = $row;  
			
			$message = "Akun anda telah diblokir!";
			echo "<script type='text/javascript'>alert('$message');window.location.href='../pages/apps-lgn'</script>";
        }
		if($login_ok and $row['usrcred']==1){ 
            unset($row['salt']); 
            unset($row['password']); 
            $_SESSION['user'] = $row;  
			
			header("Location: ../adm-wb/adm-home"); 
            die("Redirecting to: index.php"); 
        }else{ 
			$message = "Username/Password salah!";
			echo "<script type='text/javascript'>alert('$message');window.location.href='../pages/apps-lgn'</script>";
		}
		if($login_ok and $row['usrcred']==2){ 
            unset($row['salt']); 
            unset($row['password']); 
            $_SESSION['user'] = $row;  
			
			header("Location: ../web-apps/home"); 
            die("Redirecting to: index.php"); 
        }else{ 
			$message = "Username/Password salah!";
			echo "<script type='text/javascript'>alert('$message');window.location.href='../pages/apps-lgn'</script>";
		}
	}
?>