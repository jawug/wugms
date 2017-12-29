<?php 
    require("../auth/config.php");
    if(!empty($_POST)) 
    { 
        // Ensure that the user fills out fields 
        if(empty($_POST['password'])) 
        { die("Please enter a password."); } 
		if(empty($_POST['irc'])) 
        { die("Please enter a irc."); } 
        if(!filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) 
        { die("Invalid E-Mail Address/username"); } 
          
        // Check if the username is already taken
        $query = " 
            SELECT 
                1 
            FROM tbl_base_user 
            WHERE 
                username = :username 
        "; 
        $query_params = array( ':username' => $_POST['username'] ); 
        try { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 
        $row = $stmt->fetch(); 
        if($row){ die("This username is already in use"); } 
//        $query = " 
//            SELECT 
//                1 
//            FROM tbl_base_user 
//            WHERE 
//                email = :email 
//        "; 
//        $query_params = array( 
//            ':email' => $_POST['email'] 
//        ); 
//        try { 
//            $stmt = $db->prepare($query); 
//            $result = $stmt->execute($query_params); 
//        } 
//        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage());} 
//        $row = $stmt->fetch(); 
//        if($row){ die("This email address is already registered"); } 
          
        // Add row to database 
        $query = " 
            INSERT INTO tbl_base_user ( 
				irc_nick,
                username, 
                password, 
                salt,
			    acc_val_key				
            ) VALUES ( 
				:irc,
                :username, 
                :password, 
                :salt,
				:acc_val_key
            ) 
        "; 
          
        // Security measures
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
        $password = hash('sha256', $_POST['password'] . $salt); 
		for($round = 0; $round < 65536; $round++){ $password = hash('sha256', $password . $salt); } 
		// Create register key
		$user_auth_salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
        $user_auth_code = hash('sha256', date("Y-m-d h:i:sa") . $user_auth_salt); 
		for($round = 0; $round < 65536; $round++){ $user_auth_code = hash('sha256', $user_auth_code . $user_auth_salt); }
		
		
        $query_params = array( 
            ':username' => $_POST['username'], 
			':irc' => $_POST['irc'],
            ':password' => $password, 
            ':salt' => $salt,
			':acc_val_key' => $user_auth_code
        ); 
        try {  
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 
        header("Location: index.php"); 
        die("Redirecting to index.php"); 
    } 
?>