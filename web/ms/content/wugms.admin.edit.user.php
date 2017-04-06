<?php
/* Start session */
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* variables*/
$iserror   = false;
$errorcode = "";

if (isValueInRoleArray($_SESSION["roles"], "admin")) {
    if (!empty($_POST)) {
        /* Check and validate the first name that was supplied */
        if (empty($_POST['editfirstName'])) {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isBlankFirstName";
            // If the var is blank then fail
        } else {
            // Check if the var supplied fits into regex 
            if (!preg_match("/^[a-z]{1,20}$/i", $_POST['editfirstName'])) {
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isFirstNameNotCorrect";
            }
        }

        /* If there is no error so far then check the next varible */
        if ($iserror === false) {        
			/* Check and validate the first name that was supplied */
			if (empty($_POST['editlastName'])) {
				// Set the error flag as we do not want the process to run further
				$iserror   = true;
				// Set the error code
				$errorcode = "isBlankLastName";
				// If the var is blank then fail
			} else {
				// Check if the var supplied fits into regex 
				if (!preg_match("/^[a-z]{1,20}$/i", $_POST['editlastName'])) {
					// Set the error flag as we do not want the process to run further
					$iserror   = true;
					// Set the error code
					$errorcode = "isLastNameNotCorrect";
				}
			}
		}
		
        /* If there is no error so far then check the next varible */
        if ($iserror === false) {        
			/* Check and validate the first name that was supplied */
			if (empty($_POST['editircnick'])) {
				// Set the error flag as we do not want the process to run further
				$iserror   = true;
				// Set the error code
				$errorcode = "isBlankIRCNickNew";
				// If the var is blank then fail
			} else {
				// Check if the var supplied fits into regex 
				if (!preg_match("/^[A-Za-z0-9_]{3,20}$/", $_POST['editircnick'])) {
					// Set the error flag as we do not want the process to run further
					$iserror   = true;
					// Set the error code
					$errorcode = "isIRCNickNewNotCorrect";
				} else {
					if (empty($_POST['edit_user_oem_irc_nick'])) {
						// Set the error flag as we do not want the process to run further
						$iserror   = true;
						// Set the error code
						$errorcode = "isBlankIRCNickOld";
						// If the var is blank then fail
					} else {
						// Check if the var supplied fits into regex 
						if (!preg_match("/^[A-Za-z0-9_]{3,20}$/", $_POST['edit_user_oem_irc_nick'])) {
							// Set the error flag as we do not want the process to run further
							$iserror   = true;
							// Set the error code
							$errorcode = "isIRCNickOldNotCorrect";
						} else {
						/* Now check the database */
							$snquery        = "SELECT 1 FROM tbl_base_user WHERE upper(irc_nick) = upper(:new_ircnick) and not upper(irc_nick) = upper(:edit_user_oem_irc_nick) ;";
							/* Set up the parameters for teh query */
							$snquery_params = array(
								':new_ircnick' => $_POST["editircnick"],
								':edit_user_oem_irc_nick' => $_POST["edit_user_oem_irc_nick"]
							);
							try {
								$snstmt   = $db->prepare($snquery);
								$snresult = $snstmt->execute($snquery_params);
							}
							catch (PDOException $ex) {
								die("Failed to run query: " . $ex->getMessage());
							}
							$snrow = $snstmt->fetch();
							if ($snrow) {
								// Set the error flag as we do not want the process to run further
								$iserror   = true;
								// Set the error code
								$errorcode = "isIRCNickAlreadyUsed";
							}
						}
					}
				}
			}
		}
		
        /* If there is no error so far then check the next varible */
        if ($iserror === false) {        
			/* Check and validate the first name that was supplied */
			if (empty($_POST['editemail'])) {
				// Set the error flag as we do not want the process to run further
				$iserror   = true;
				// Set the error code
				$errorcode = "isBlankEmailNew";
				// If the var is blank then fail
			} else {
				// Check if the var supplied fits into regex 
				if (!filter_var($_POST['editemail'], FILTER_VALIDATE_EMAIL)) {
					// Set the error flag as we do not want the process to run further
					$iserror   = true;
					// Set the error code
					$errorcode = "isEmailNewNotCorrect";
				} else {
					if (empty($_POST['edit_user_oem_email'])) {
						// Set the error flag as we do not want the process to run further
						$iserror   = true;
						// Set the error code
						$errorcode = "isBlankEmailOld";
						// If the var is blank then fail
					} else {
						// Check if the var supplied fits into regex 
						if (!filter_var($_POST['edit_user_oem_email'], FILTER_VALIDATE_EMAIL)) {
							// Set the error flag as we do not want the process to run further
							$iserror   = true;
							// Set the error code
							$errorcode = "isEmailOldNotCorrect";
						} else {
							/* Now check the database */
							$snquery        = "SELECT 1 FROM tbl_base_user WHERE upper(username) = upper(:editemail) and not upper(username) = upper(:edit_user_oem_email);";
							/* Set up the parameters for teh query */
							$snquery_params = array(
								':editemail' => $_POST["editemail"],
								':edit_user_oem_email' => $_POST["edit_user_oem_email"]
							);
							try {
								$snstmt   = $db->prepare($snquery);
								$snresult = $snstmt->execute($snquery_params);
							}
							catch (PDOException $ex) {
								die("Failed to run query: " . $ex->getMessage());
							}
							$snrow = $snstmt->fetch();
							if ($snrow) {
								// Set the error flag as we do not want the process to run further
								$iserror   = true;
								// Set the error code
								$errorcode = "isEmailAlreadyUsed";
							}
						}
					}
				}
			}
		}		
    
        /* If there is no error so far then check the next varible */
        if ($iserror === false) {        
			/* Check and validate the first name that was supplied */
			if (empty($_POST['editphone'])) {
				// Set the error flag as we do not want the process to run further
				$iserror   = true;
				// Set the error code
				$errorcode = "isBlankPhone";
				// If the var is blank then fail
			} else {
				// Check if the var supplied fits into regex 
				if (!preg_match("/^\+27?[\d]{2}?[\d]{3}?[\d]{4}$/", $_POST['editphone'])) {
					// Set the error flag as we do not want the process to run further
					$iserror   = true;
					// Set the error code
					$errorcode = "isPhoneNotCorrect";
				}
			}
		}
    
        /* If there is no error so far then check the next varible */
        if ($iserror === false) {        
			/* Check and validate the first name that was supplied */
			if (empty($_POST['editdob'])) {
				// Set the error flag as we do not want the process to run further
				$iserror   = true;
				// Set the error code
				$errorcode = "isBlankDoB";
				// If the var is blank then fail
			} else {
				// Check if the var supplied fits into regex 
				if (!preg_match("/^(19|20)\d\d[- \/.](0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])$/", $_POST['editdob'])) {
					// Set the error flag as we do not want the process to run further
					$iserror   = true;
					// Set the error code
					$errorcode = "isDoBNotCorrect";
				}
			}
		}
		
		/* editaccstatus */
		
        /* If there is no error so far then check the next varible */
        if ($iserror === false) {        
			/* Check and validate the first name that was supplied */
			if (empty($_POST['edit_user_oem_user_id'])) {
				// Set the error flag as we do not want the process to run further
				$iserror   = true;
				// Set the error code
				$errorcode = "isBlankID";
				// If the var is blank then fail
			} else {
				/* Now check the database */
				$snquery        = "SELECT 1 FROM tbl_base_user WHERE idtbl_base_user = :edit_user_oem_user_id;";
				/* Set up the parameters for teh query */
				$snquery_params = array(
					':edit_user_oem_user_id' => $_POST["edit_user_oem_user_id"]
				);
				try {
					$snstmt   = $db->prepare($snquery);
					$snresult = $snstmt->execute($snquery_params);
				}
				catch (PDOException $ex) {
					die("Failed to run query: " . $ex->getMessage());
				}
				$snrow = $snstmt->fetch();
				if ($snrow) {
					// So that id exists
				} else {
					// Set the error flag as we do not want the process to run further
					$iserror   = true;
					// Set the error code
					$errorcode = "isBadID";				
				}
			}
		}		
		
        if ($iserror === false) {        
			/* Check and validate the first name that was supplied */
			if (empty($_POST['editmaxsites'])) {
				// Set the error flag as we do not want the process to run further
				$iserror   = true;
				// Set the error code
				$errorcode = "isBlankMaxSites";
				// If the var is blank then fail
			} else {
				// Check if the var supplied fits into regex 
				if (!($_POST['editmaxsites'] >= 1) or !($_POST['editmaxsites'] <= 100)) {
					// Set the error flag as we do not want the process to run further
					$iserror   = true;
					// Set the error code
					$errorcode = "isMaxSitesNotCorrect";
				}
			}
		}		
        

		
        
        /* Seeing as there is no error then create the site entry */
        if ($iserror === false) {
		
			/* Update the user table */
            // Query for the user table
            $query = "UPDATE tbl_base_user
   SET username = :username,
       irc_nick = :irc_nick,
       firstName = :firstName,
       lastName = :lastName,
       max_sites = :max_sites,
       acc_status = :acc_status,
       dob = :dob,
       phone_num = :phone_num
 WHERE idtbl_base_user = :user_id;";
			/* Params for teh user table query */
            $query_params = array(
                ':username' => $_POST['editemail'],
                ':irc_nick' => $_POST['editircnick'],
                ':firstName' => $_POST['editfirstName'],
                ':lastName' => $_POST['editlastName'],
                ':max_sites' => $_POST['editmaxsites'],
                ':acc_status' => $_POST['editaccstatus'],
				':dob' => $_POST['editdob'],
				':phone_num' => $_POST['editphone'],
                ':user_id' => $_POST['edit_user_oem_user_id']
            );
			/*  */
            try {
                $stmt   = $db->prepare($query);
                $result = $stmt->execute($query_params);
                /* First log into the audit table that there was a change request and it met the requirements */
                wugmsaudit("admin", "edit", "users", "Edited user - " . $_POST['edit_user_oem_irc_nick'] . "->" . $_POST['editircnick'] . " UID" . $_POST['edit_user_oem_user_id']);
            }
            catch (PDOException $ex) {
                $newuser = false;
                echo "<span class=\"alert alert-danger\" >Failed to edit user1. Reason " . $ex->getMessage() . "</span><br><br>";
            }
			
			
			/* User levels START */
			
		/* readonlylevel_val */
		/* adminlevel_val */
		/* betalevel_val */			
			/* Section to remove the "addon" roles like admin/beta/readonly */
            $query_user_update_1 = "DELETE FROM tbl_ae_user_rolls WHERE username_id = :user_id AND (roll_id = 'admin' OR roll_id = 'readonly' OR roll_id = 'beta');";
            /* Setting the params */
            $query_params_user_update_1 = array(
                ':user_id' => $_POST['edit_user_oem_user_id']
            ); 
            try {
                $stmt_user_update_1   = $db->prepare($query_user_update_1);
                $result_user_update_1 = $stmt_user_update_1->execute($query_params_user_update_1);
            }
            catch (PDOException $ex) {
                die("Failed to run query: " . $ex->getMessage());
            } 

            /* Section to update all the RBs that are allocated to that site but just the sitename */
            /*$query_user_update_2 = "INSERT INTO tbl_ae_user_rolls(username_id, roll_id) VALUES (:user_id, :access_level);"; */
            /* Setting the params */

			/* readonlylevel_val */
			if (!empty($_POST['readonlylevel_val'])) {
				if ($_POST['readonlylevel_val'] == 'true') {
					$query_user_update_2 = "INSERT INTO tbl_ae_user_rolls(username_id, roll_id) VALUES (:user_id, :access_level);"; 
					$query_params_user_update_2 = array(
						':user_id' => $_POST['edit_user_oem_user_id'],
						':access_level' => "readonly"
					); 
					try {
						$stmt_user_update_2   = $db->prepare($query_user_update_2);
						$result_user_update_2 = $stmt_user_update_2->execute($query_params_user_update_2);
						}
					catch (PDOException $ex) {
						die("Failed to run query: " . $ex->getMessage());
						}
					//echo "The user must get 'readonly' level access.  ";
				}
			}
		
			/* adminlevel_val */
			if (!empty($_POST['adminlevel_val'])) {
				if ($_POST['adminlevel_val'] == 'true') {
					$query_user_update_2 = "INSERT INTO tbl_ae_user_rolls(username_id, roll_id) VALUES (:user_id, :access_level);"; 
					$query_params_user_update_2 = array(
						':user_id' => $_POST['edit_user_oem_user_id'],
						':access_level' => "admin"
					); 
					try {
						$stmt_user_update_2   = $db->prepare($query_user_update_2);
						$result_user_update_2 = $stmt_user_update_2->execute($query_params_user_update_2);
						}
					catch (PDOException $ex) {
						die("Failed to run query: " . $ex->getMessage());
						}
				//echo "The user must get 'admin' level access.";
				}
			}
		
			/* betalevel_val */
			if (!empty($_POST['betalevel_val'])) {
				if ($_POST['betalevel_val'] == 'true') {
					$query_user_update_2 = "INSERT INTO tbl_ae_user_rolls(username_id, roll_id) VALUES (:user_id, :access_level);"; 
					$query_params_user_update_2 = array(
						':user_id' => $_POST['edit_user_oem_user_id'],
						':access_level' => "beta"
					); 
					try {
						$stmt_user_update_2   = $db->prepare($query_user_update_2);
						$result_user_update_2 = $stmt_user_update_2->execute($query_params_user_update_2);
						}
					catch (PDOException $ex) {
						die("Failed to run query: " . $ex->getMessage());
						}
				//echo "The user must get 'beta' level access.";
				}
			}
			
/*            try {
                $stmt_user_update_21   = $db->prepare($query_rb_user_update_2);
                $result_user_update_2 = $stmt_user_update_2->execute($query_params_user_update_2);
            }
            catch (PDOException $ex) {
                die("Failed to run query: " . $ex->getMessage());
            } */
			
			/* User levels end */
        } else {
            echo "<span class=\"alert alert-danger\" >Failed to edit user2. Reason " . $errorcode . "</span><br><br>";
        }
    } else {
        echo "<span class=\"alert alert-danger\" >Failed to edit user3. Reason DATA_NOT_POSTED</span><br><br>";
    }
}
?>