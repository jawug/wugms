<?php

class entity_user {

    /**
     *
     * @var object This the DAO object 
     */
    private $cdb;

    /**
     *
     * @var object This is the Mailer object
     */
    public $mail;

    /**
     *
     * @var object This contains the smtp settings 
     */
    private $mailer_settings;

    /**
     *
     * @var integer This is the user's ID 
     */
    private $user_id;

    /**
     *
     * @var string This is the user's firstname 
     */
    private $name;

    /**
     *
     * @var string This is the user's Sruname 
     */
    private $surname;

    /**
     *
     * @var string This is the user's username as well as email address  
     */
    private $username;

    /**
     *
     * @var string This is the user's account status 
     */
    private $account_status;

    /**
     *
     * @var integer This is the user's company that they belong to 
     */
    private $company_id;

    /**
     *
     * @var integer This is the user's company that they belong to 
     */
    private $user_create_date;

    /**
     *
     * @var string salt value for the password 
     */
    private $user_auth_salt;

    /**
     *
     * @var integer This is the account type that the user can have 
     */
    private $user_type;

    /**
     *
     * @var string This is the auth code 
     */
    private $user_auth_code;

    /**
     *
     * @var string This is the password 
     */
    private $password;

    /**
     *
     * @var array This contains all of teh roles that the user has
     */
    private $roles;

    /**
     *
     * @var string This is the account validation key 
     */
    private $acc_val_key;

    /**
     *
     * @var string temp placeholder for URL 
     */
    private $usrurl;

    /**
     *
     * @var string temp placeholder for email contents 
     */
    private $email_template;

    /**
     *
     * @var string 
     */
    private $email_msg;

    /**
     *
     * @var boolean 
     */
    private $dao_status;

    /**
     * 
     * @return integer ID of the original feedback
     */
    function getID() {
        return $this->user_id;
    }

    /**
     * 
     * @param integer $id This sets the internal variable
     */
    function setID($id) {
        $this->user_id = $id;
    }

    /**
     * 
     * @return string User's name
     */
    function getName() {
        return $this->name;
    }

    /**
     * 
     * @param string $name This sets the internal variable
     */
    function setName($name) {
        $this->name = $name;
    }

    /**
     * 
     * @return string User's surname
     */
    function getSurname() {
        return $this->surname;
    }

    /**
     * 
     * @param string $surname This sets the internal variable
     */
    function setSurname($surname) {
        $this->surname = $surname;
    }

    /**
     * 
     * @return string Username
     */
    function getUserName() {
        return $this->username;
    }

    /**
     * 
     * @param string $username This sets the internal variable
     */
    function setUserName($username) {
        $this->username = $username;
    }

    /**
     * 
     * @return integer ID of the original feedback
     */
    function getAccountStatus() {
        return $this->account_status;
    }

    /**
     * 
     * @param integer $account_status This sets the internal variable
     */
    function setAccountStatus($account_status) {
        $this->account_status = $account_status;
    }

    function getCompanyName() {
        return $this->company_name;
    }

    /**
     * 
     * @return array
     */
    function getUserRoles() {
        return $this->roles;
    }

    function getStatusName() {
        return $this->user_status;
    }

    /**
     * 
     * @return integer ID of the company
     */
    function getCompanyID() {
        return $this->company_id;
    }

    /**
     * 
     * @param integer $company_id This sets the internal variable
     */
    function setCompanyID($company_id) {
        $this->company_id = $company_id;
    }

    /**
     * 
     * @return string Name of user type
     */
    function getUserType() {
        return $this->user_type;
    }

    /**
     * 
     * @param string $user_type This sets the internal variable
     */
    function setUserType($user_type) {
        $this->user_type = $user_type;
    }

    /**
     * 
     * @return integer ID of the account type
     */
    function getUserTypeID() {
        return $this->user_type_id;
    }

    /**
     * 
     * @param integer $user_type_id This sets the internal variable
     */
    function setUserTypeID($user_type_id) {
        $this->user_type_id = $user_type_id;
    }

    function getUserCreateDate() {
        return $this->user_create_date;
    }

    /**
     * 
     * @return string ID of the company
     */
    function getAccValKey() {
        return $this->acc_val_key;
    }

    /**
     * 
     * @param string $acc_val_key This creates a a user account key that gets used in future operations
     */
    function setAccValKey($acc_val_key = null) {
        if ($acc_val_key) {
            $this->acc_val_key = $acc_val_key;
        } else {
            $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
            $this->user_auth_code = hash('sha256', date("Y-m-d h:i:sa") . $salt);
            for ($round = 0; $round < 65536; $round++) {
                $this->user_auth_code = hash('sha256', $this->user_auth_code . $salt);
            }
            $this->acc_val_key = $this->user_auth_code;
        }
    }

    /**
     * 
     * @return string Return the auth salt
     */
    function getAuthSalt() {
        return $this->user_auth_salt;
    }

    /**
     * 
     * @param string $user_auth_salt This sets the internal variable
     */
    function setAuthSalt($user_auth_salt = null) {
        if ($user_auth_salt) {
            $this->user_auth_salt = $user_auth_salt;
        } else {
            $this->user_auth_salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
        }
    }

    /**
     * 
     * @return string
     */
    function getAuthCode() {
        return $this->user_auth_code;
    }

    /**
     * 
     * @return string Return the auth code
     */
    function setAuthCode($user_auth_code = null) {
        if ($user_auth_code) {
            $this->user_auth_code = $user_auth_code;
        } else {
            $this->user_auth_code = hash('sha256', date("Y-m-d h:i:sa") . $this->user_auth_salt);
            for ($round = 0; $round < 65536; $round++) {
                $this->user_auth_code = hash('sha256', $this->user_auth_code . $this->user_auth_salt);
            }
        }
    }

    /**
     * 
     * @return string stuff
     */
    function getPassword() {
        return $this->password;
    }

    /**
     * 
     * @param string $password This sets the internal variable
     */
    function setPassword($password) {
        $password_hash = hash('sha256', $password . $this->getAuthSalt());
        for ($round = 0; $round < 65536; $round++) {
            $password_hash = hash('sha256', $password_hash . $this->getAuthSalt());
        }
        $this->password = $password_hash;
//        $check_password = hash('sha256', $_POST['epass'] . $user_check_row['salt']);
//        for ($round = 0; $round < 65536; $round++) {
//            $check_password = hash('sha256', $check_password . $user_check_row['salt']);
//        }
    }

    function DAOGetUserRoles($user_id) {
        if (!$this->cdb) {
            $this->initDAO();
        }
        if ($this->ClassActions->getStatus()) {
            /* SQL - Query */
            $get_user_roles_query = "SELECT b.role_name AS role, b.role_description AS comment FROM tbl_ae_user_roles a, tbl_base_roles b WHERE a.fk_user = :user_id AND a.fk_role = b.id_role;";
            /* SQL - Params */
            $get_user_roles_query_params = array(':user_id' => $user_id);
            /* SQL - Exec */
            try {
                $get_user_roles_query_stmt = $this->cdb->prepare($get_user_roles_query);
                $get_user_roles_query_stmt->execute($get_user_roles_query_params);
            } catch (PDOException $ex) {
                $this->ClassActions->setStatus(FALSE);
                $this->ClassActions->setStatusCode("get_user_roles_query_stmt");
                $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
                $this->ClassActions->setLine($ex->getLine());
            }
            /* SQL - Process Results */
            if ($this->ClassActions->getStatus()) {
                /* SQL - Result(s) */
                $get_user_roles_query_row = $get_user_roles_query_stmt->fetch();
                if ($get_user_roles_query_row) {
                    $this->user_roles = $get_user_roles_query_row;
                } else {
                    $this->ClassActions->setStatus(FALSE);
                    $this->ClassActions->setStatusCode("User not assigned any roles");
                }
            }
        }
        return $this->ClassActions;
    }

    /**
     * 
     * @param integer $user_id This uses the supplied var to get the user's details from the database.
     */
    function DAOGetUserDetails($user_id) {
        if (!$this->cdb) {
            $this->initDAO();
        }
        if ($this->ClassActions->getStatus()) {
            /* SQL - Query */
            $get_user_details_query = "SELECT a.id_user, a.user_username, a.user_firstname, a.user_lastname, a.password, a.fk_company, a.salt, a.user_cdate, a.fk_status, a.acc_val_key, a.fk_security_question, a.security_question_answer, a.fk_user_type AS 'user_type_id', b.user_type AS 'user_type_name', c.user_status, d.company_name FROM tbl_base_users a, tbl_base_user_type b, tbl_base_user_status c, tbl_base_companies d WHERE a.id_user = :user_id AND a.fk_user_type = b.id_user_type AND a.fk_status = c.id_user_status AND a.fk_company = d.id_company;";
            /* SQL - Params */
            $get_user_details_query_params = array(':user_id' => $user_id);
            /* SQL - Exec */
            try {
                $get_user_details_query_stmt = $this->cdb->prepare($get_user_details_query);
                $get_user_details_query_stmt->execute($get_user_details_query_params);
            } catch (PDOException $ex) {
                $this->ClassActions->setStatus(FALSE);
                $this->ClassActions->setStatusCode("get_user_details_query_stmt");
                $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
                $this->ClassActions->setLine($ex->getLine());
            }
            /* SQL - Process Results */
            if ($this->ClassActions->getStatus()) {
                /* SQL - Result(s) */
                $get_user_details_query_row = $get_user_details_query_stmt->fetch();
                if ($get_user_details_query_row) {
                    $this->user_id = $get_user_details_query_row['id_user'];
                    $this->username = $get_user_details_query_row['user_username'];
                    $this->name = $get_user_details_query_row['user_firstname'];
                    $this->surname = $get_user_details_query_row['user_lastname'];
                    $this->password = $get_user_details_query_row['password'];
                    $this->company_id = $get_user_details_query_row['fk_company'];
                    $this->company_name = $get_user_details_query_row['company_name'];
                    $this->user_auth_salt = $get_user_details_query_row['salt'];
                    $this->user_create_date = $get_user_details_query_row['user_cdate'];
                    $this->account_status = $get_user_details_query_row['fk_status'];
                    $this->acc_val_key = $get_user_details_query_row['acc_val_key'];
                    $this->user_status = ucwords($get_user_details_query_row['user_status']);
//            $this-> = $get_user_details_query_row['fk_security_question'];
//            $this->user_id = $get_user_details_query_row['security_question_answer'];
                    $this->user_type_id = $get_user_details_query_row['user_type_id'];
                    $this->user_type = $get_user_details_query_row['user_type_name'];
                } else {
                    $this->ClassActions->setStatus(FALSE);
                    $this->ClassActions->setStatusCode("No such user");
                }
            }
        }
        return $this->ClassActions;
    }

    /**
     * 
     * @param string $sessionID
     * @param string $level
     * @param string $action
     * @param string $area
     * @param string $msg
     * @return \StatusVO
     */
    function DAOUserAudit($sessionID, $level, $action, $area, $msg) {
        if (!$this->cdb) {
            $this->initDAO();
        }
        if ($this->ClassActions->getStatus()) {
            /* SQL - Query */
            $insert_user_audit_query = "INSERT INTO tbl_base_user_audit(username, username_id, session_id, user_ip, level, area, action, msg, browser_agent, sid) VALUES (:username, :username_id, :session_id, :userip, :level, :area, :action, :msg, :browser_agent, :sid);";
            /* SQL - Params */
            $insert_user_audit_query_params = array(
                ':username' => $this->getUserName(),
                ':username_id' => $this->getID(),
                ':session_id' => $sessionID,
                ':browser_agent' => $this->getHTTPUserAgent(),
                ':userip' => $this->getClientIP(),
                ':level' => $level,
                ':area' => $area,
                ':action' => $action,
                ':msg' => $msg,
                ':sid' => microtime(true)
            );
            /* SQL - Exec */
            try {
                $insert_user_audit_query_stmt = $this->cdb->prepare($insert_user_audit_query);
                $insert_user_audit_query_stmt->execute($insert_user_audit_query_params);
            } catch (PDOException $ex) {
                $this->ClassActions->setStatus(FALSE);
                $this->ClassActions->setStatusCode("role_clean_stmt");
                $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
                $this->ClassActions->setLine($ex->getLine());
            }
        }
        return $this->ClassActions;
    }

    /**
     * 
     * @param array $roles This contains the list of roles that the user is meant to be assigned
     * @param boolean $keep_main This indicates if the exiting roles should be kept
     * @return \StatusVO
     */
    function DAOUpdateUserRoles($roles, $keep_main = true) {
        if (!$this->cdb) {
            $this->initDAO();
        }
        if ($this->ClassActions->getStatus()) {
            /* SQL - Query */
            if ($keep_main) {
                $role_clean_query = "DELETE FROM tbl_ae_user_roles WHERE fk_user = :fk_user and fk_role <> 7;";
            } else {
                $role_clean_query = "DELETE FROM tbl_ae_user_roles WHERE fk_user = :fk_user;";
            }
            /* SQL - Params */
            $role_clean_params = array(
                ':fk_user' => $this->getID()
            );
            /* SQL - Exec */
            try {
                $role_clean_stmt = $this->cdb->prepare($role_clean_query);
                $role_clean_stmt->execute($role_clean_params);
            } catch (PDOException $ex) {
                $this->ClassActions->setStatus(FALSE);
                $this->ClassActions->setStatusCode("role_clean_stmt");
                $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
                $this->ClassActions->setLine($ex->getLine());
            }
            if ($this->ClassActions->getStatus() && $roles) {
                $items = count($roles);
                for ($i = 0; $i < $items; $i++) {
                    /* SQL - Query */
                    $role_add_query = "INSERT INTO tbl_ae_user_roles(fk_user, fk_role) VALUES (:fk_user, :fk_role);";
                    /* SQL - Params */
                    $role_add_params = array(
                        ':fk_user' => $this->getID(),
                        ':fk_role' => $roles[$i]
                    );
                    /* SQL - Exec */
                    try {
                        $role_add_stmt = $this->cdb->prepare($role_add_query);
                        $role_add_result = $role_add_stmt->execute($role_add_params);
                    } catch (PDOException $ex) {
                        $this->ClassActions->setStatus(FALSE);
                        $this->ClassActions->setStatusCode("role_add_stmt");
                        $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
                        $this->ClassActions->setLine($ex->getLine());
                    }
                }
            }
        }
        return $this->ClassActions;
    }

    function DAOUpdateAccountStatus($status) {
        if (!$this->cdb) {
            $this->initDAO();
        }
        if ($this->ClassActions->getStatus()) {
            /* SQL - Query */
            $update_account_status_query = "UPDATE tbl_base_users set fk_status =:fk_status where id_user = :id_user ;";
            /* SQL - Params  */
            $update_account_status_query_params = array(
                ':id_user' => $this->getID(),
                ':fk_status' => $status
            );
            /* SQL - Exec */
            try {
                $update_account_status_query_stmt = $this->cdb->prepare($update_account_status_query);
                $update_account_status_query_stmt->execute($update_account_status_query_params);
            } catch (PDOException $ex) {
                $this->ClassActions->setStatus(FALSE);
                $this->ClassActions->setStatusCode("update_account_status_query_stmt");
                $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
                $this->ClassActions->setLine($ex->getLine());
            }
        }
        return $this->ClassActions;
    }

    function DAOUpdateAccountPassword() {
        if (!$this->cdb) {
            $this->initDAO();
        }
        if ($this->ClassActions->getStatus()) {
            /* SQL - Query */
            $update_account_password_query = "UPDATE tbl_base_users set fk_status = :fk_status, password = :password, salt = :salt, acc_val_key = :acc_val_key where id_user = :id_user ;";
            /* SQL - Params  */
            $update_account_password_query_params = array(
                ':id_user' => $this->getID(),
                ':fk_status' => $this->getAccountStatus(),
                ':password' => $this->getPassword(),
                ':salt' => $this->getAuthSalt(),
                ':acc_val_key' => $this->getAccValKey()
            );
            /* SQL - Exec */
            try {
                $update_account_password_query_stmt = $this->cdb->prepare($update_account_password_query);
                $update_account_password_query_stmt->execute($update_account_password_query_params);
            } catch (PDOException $ex) {
                $this->ClassActions->setStatus(FALSE);
                $this->ClassActions->setStatusCode("update_account_status_query_stmt");
                $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
                $this->ClassActions->setLine($ex->getLine());
            }
        }
        return $this->ClassActions;
    }

    function DAOUpdateUserTeams($teams, $keep_main = true) {
        if (!$this->cdb) {
            $this->initDAO();
        }
        if ($this->ClassActions->getStatus()) {
            /* SQL - Query */
            $role_clean_query = "DELETE FROM tbl_ae_user_teams WHERE fk_user = :fk_user;";
            /* SQL - Params  */
            $role_clean_params = array(
                ':fk_user' => $this->getID()
            );
            /* SQL - Exec */
            try {
                $role_clean_stmt = $this->cdb->prepare($role_clean_query);
                $role_clean_stmt->execute($role_clean_params);
            } catch (PDOException $ex) {
                $this->ClassActions->setStatus(FALSE);
                $this->ClassActions->setStatusCode("role_clean_stmt");
                $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
                $this->ClassActions->setLine($ex->getLine());
            }
            if ($this->ClassActions->getStatus() && $teams) {
                $items = count($teams);
                for ($i = 0; $i < $items; $i++) {
                    /* SQL - Query */
                    $role_add_query = "INSERT INTO tbl_ae_user_teams(fk_user, fk_team) VALUES (:fk_user, :fk_team);";
                    /* SQL - Params */
                    $role_add_params = array(
                        ':fk_user' => $user_id,
                        ':fk_team' => $teams[$i]
                    );
                    /* SQL - Exec */
                    try {
                        $role_add_stmt = $this->cdb->prepare($role_add_query);
                        $role_add_stmt->execute($role_add_params);
                    } catch (PDOException $ex) {
                        $this->ClassActions->setStatus(FALSE);
                        $this->ClassActions->setStatusCode("role_add_stmt");
                        $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
                        $this->ClassActions->setLine($ex->getLine());
                    }
                }
            }
        }
        return $this->ClassActions;
    }

    /**
     * This function sets the settings that the SMTP phpmailer needs in order to do its thing.
     */
    private function SetMailerSettings() {
        $this->mail->isSMTP();
        $this->mail->SMTPDebug = 1;
        $this->mail->Debugoutput = 'error_log';
        $this->mail->Host = $this->mailer_settings->getSMTPHost();
        $this->mail->Port = $this->mailer_settings->getSMTPPort();
        $this->mail->SMTPSecure = $this->mailer_settings->getSMTPSecure();
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $this->mailer_settings->getSMTPUsername();
        $this->mail->Password = $this->mailer_settings->getSMTPPassword();
        $this->mail->Timeout = 5;
        $this->mail->AltBody = 'This is a plain-text message body';
    }

    /**
     * Populate the invite email
     */
    function setInviteEmailTemplate() {
        $this->email_template = file_get_contents($this->DecoratorPattern->getServerBase() . "/../lib/invite.template.html");
        $this->email_msg = str_replace(
                array(
            "{sitename}",
            "{name}",
            "{surname}",
            "{username}",
            "{usrurl}",
            "{bwcfwadminemail}"
                ), array(
            $this->branding->getShortSiteName(),
            $this->getName(),
            $this->getSurname(),
            $this->getUserName(),
            $this->usrurl,
            $this->branding->getbwcfwAdmineMail()
                ), $this->email_template);
    }

    /**
     * This function sends an email to the user letting them know that an account has been created for them
     */
    function sendInviteEmail() {
        $this->mail->addAddress($this->getUserName());
        $this->mail->Subject = $this->branding->getShortSiteName() . " - a user account has been created on your behalf";
        $this->mail->addReplyTo($this->mailer_settings->getNoreplyAddress(), $this->mailer_settings->getNoreplyName());
        if ($this->getCompanyID() === '1') {
            $this->usrurl = $this->branding->getBaseURLInternal() . "/bwcfw/auth/account_activate.php?user=" . $this->getUserName() . "&verify=" . $this->acc_val_key;
        } else {
            $this->usrurl = $this->branding->getBaseURL() . "/bwcfw/auth/account_activate.php?user=" . $this->getUserName() . "&verify=" . $this->acc_val_key;
        }
        $this->setInviteEmailTemplate();
        $this->mail->msgHTML($this->email_msg);
        $fn = $this->DecoratorPattern->getEmailsPath() . "/invite." . microtime() . ".html";
        file_put_contents($fn, $this->email_msg);
    }

    /**
     * This function inits the DAO
     */
    private function initDAO() {
        try {
            $this->cdb = new PDO("mysql:host={$this->database_settings->getHost()};dbname={$this->database_settings->getDataBase()};charset={$this->database_settings->getCharset()}", $this->database_settings->getUserName(), $this->database_settings->getPassword(), $this->database_settings->getDataBaseOptions());
        } catch (PDOException $ex) {
            $this->ClassActions->setStatus(FALSE);
            $this->ClassActions->setStatusCode("init DAO");
            $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
            $this->ClassActions->setLine($ex->getLine());
        }
        if ($this->ClassActions->getStatus()) {
            $this->cdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->cdb->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
    }

    function __construct($user_id = null) {
        /* Records */
        $this->branding = new bwcfwDecoratorPattern();
        $this->database_settings = new DBVO();
        $this->mailer_settings = new SMTPVO();
        $this->ClassActions = new StatusVO();
        /* Mailer */
        require_once 'phpmailer/PHPMailerAutoload.php';
        $this->mail = new PHPMailer(true);
        $this->SetMailerSettings();
        /* If there is a populated $user_id then get the details for that */
        if ($user_id) {
            if ($this->ClassActions->getStatus()) {
                $this->DAOGetUserDetails($user_id);
                $this->DAOGetUserRoles($user_id);
            }
        }
    }

}
