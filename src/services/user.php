<?php

class serviceUser
{

    /**
     *
     * @var \ServiceDAO This the DAO object 
     */
    private $DAO;

    /**
     *
     * @var \LoggingService Logging Service 
     */
    private $configuration;

    /**
     *
     * @var \voStatus Status ValueObject 
     */
    private $ClassActions;

    /**
     *
     * @var \ServiceEmailer This is the Mailer object
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
    private $site_id;

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
    function getID()
    {
        return $this->user_id;
    }

    /**
     * 
     * @param integer $id This sets the internal variable
     */
    function setID($id)
    {
        $this->user_id = $id;
    }

    /**
     * 
     * @return string User's name
     */
    function getName()
    {
        return $this->name;
    }

    /**
     * 
     * @param string $name This sets the internal variable
     */
    function setName($name)
    {
        $this->name = $name;
    }

    /**
     * 
     * @return string User's surname
     */
    function getSurname()
    {
        return $this->surname;
    }

    /**
     * 
     * @param string $surname This sets the internal variable
     */
    function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * 
     * @return string Username
     */
    function getUserName()
    {
        return $this->username;
    }

    /**
     * 
     * @param string $username This sets the internal variable
     */
    function setUserName($username)
    {
        $this->username = $username;
    }

    /**
     * 
     * @return integer ID of the original feedback
     */
    function getAccountStatus()
    {
        return $this->account_status;
    }

    /**
     * 
     * @param integer $account_status This sets the internal variable
     */
    function setAccountStatus($account_status)
    {
        $this->account_status = $account_status;
    }

    /**
     * 
     * @return array
     */
    public function getUserRoles()
    {
        return $this->user_roles;
    }

    /**
     * 
     * @return interger
     */
    public function getUserRole()
    {
        return $this->user_role;
    }

    public function getStatusName()
    {
        return $this->user_status;
    }

    /**
     * 
     * @return integer ID of the company
     */
    public function getSiteID()
    {
        return $this->site_id;
    }

    /**
     * 
     * @param integer $site_id This sets the internal variable
     */
    public function setSiteID($site_id)
    {
        $this->site_id = $site_id;
    }

    /**
     * 
     * @return string Name of the site
     */
    public function getSiteName()
    {
        return $this->site_name;
    }

    /**
     * 
     * @param string $name This sets the internal variable
     */
    public function setSiteName($name)
    {
        $this->site_name = $name;
    }

    /**
     * 
     * @return string Name of user type
     */
    public function getUserType()
    {
        return $this->user_type;
    }

    /**
     * 
     * @param string $user_type This sets the internal variable
     */
    public function setUserType($user_type)
    {
        $this->user_type = $user_type;
    }

    /**
     * 
     * @return integer ID of the account type
     */
    public function getUserTypeID()
    {
        return $this->user_type_id;
    }

    /**
     * 
     * @param integer $user_type_id This sets the internal variable
     */
    public function setUserTypeID($user_type_id)
    {
        $this->user_type_id = $user_type_id;
    }

    public function getUserCreateDate()
    {
        return $this->user_create_date;
    }

    /**
     * 
     * @return string ID of the company
     */
    public function getAccValKey()
    {
        return $this->acc_val_key;
    }

    /**
     * 
     * @param string $acc_val_key This creates a a user account key that gets used in future operations
     */
    public function setAccValKey($acc_val_key = null)
    {
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
    public function getAuthSalt()
    {
        return $this->user_auth_salt;
    }

    /**
     * 
     * @return datetime
     */
    public function getAccountExpiryDate()
    {
        return $this->user_account_expiry;
    }

    /**
     * 
     * @param datetime $date
     */
    public function setAccountExpiryDate($date)
    {
        $this->user_account_expiry = $date;
    }

    /**
     * 
     * @param string $user_auth_salt This sets the internal variable
     */
    public function setAuthSalt($user_auth_salt = null)
    {
        if ($user_auth_salt) {
            $this->user_auth_salt = $user_auth_salt;
        } else {
//            $this->user_auth_salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
            $this->user_auth_salt = dechex(random_int(PHP_INT_MIN, PHP_INT_MAX)) . dechex(random_int(PHP_INT_MIN, PHP_INT_MAX)) . dechex(random_int(PHP_INT_MIN, PHP_INT_MAX)) . dechex(random_int(PHP_INT_MIN, PHP_INT_MAX)) . dechex(random_int(PHP_INT_MIN, PHP_INT_MAX)) . dechex(random_int(PHP_INT_MIN, PHP_INT_MAX)) . dechex(random_int(PHP_INT_MIN, PHP_INT_MAX)) . dechex(random_int(PHP_INT_MIN, PHP_INT_MAX));
        }
    }

    /**
     * 
     * @return string
     */
    public function getAuthCode()
    {
        return $this->user_auth_code;
    }

    /**
     * 
     * @return string Return the auth code
     */
    public function setAuthCode($user_auth_code = null)
    {
        if ($user_auth_code) {
            $this->user_auth_code = $user_auth_code;
        } else {
            $this->user_auth_code = hash('sha256', date("Y-m-d h:i:sa") . $this->user_auth_salt);
            for ($round = 0; $round < 65536; $round++) {
                $this->user_auth_code = hash('sha256', $this->user_auth_code . $this->user_auth_salt);
            }
        }
    }

    private function unpackAuthSalt()
    {
        $this->setAuthSalt(substr($this->passwordsalt, 64));
    }

    private function unpackPassword()
    {
        $this->password = substr($this->passwordsalt, 0, 64);
    }

    private function setPasswordSalt()
    {
        $this->passwordsalt = $this->getPassword() . $this->getAuthSalt();
    }

    private function getPasswordSalt()
    {
        return $this->passwordsalt;
    }

    /**
     * 
     * @param array $roles
     */
    private function setUserRoles($roles)
    {
        $this->user_roles = $roles;
    }

    /**
     * 
     * @param interger $role
     */
    function setUserRole($role)
    {
        $this->user_role = $role;
    }

    /**
     * 
     * @param string $name
     */
    function setUserRoleName($name)
    {
        $this->user_role_name = $name;
    }

    /**
     * 
     * @return string
     */
    function getUserRoleName()
    {
        return $this->user_role_name;
    }

    /**
     * 
     * @return string stuff
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * 
     * @param string $password This sets the internal variable
     */
    public function setPassword($password)
    {
        $password_hash = hash('sha256', $password . $this->getAuthSalt());
        for ($round = 0; $round < 65536; $round++) {
            $password_hash = hash('sha256', $password_hash . $this->getAuthSalt());
        }
        $this->password = $password_hash;
    }

    function DAOGetUserRoles($user_id)
    {
        if (!$this->DAO->ServiceDAO) {
            $this->ClassActions = $this->DAO->initDAO();
        }
        if ($this->ClassActions->getStatus()) {
            /* SQL - Query */
            $get_user_roles_query = "SELECT role_site AS 'roles' FROM view_users_roles_sites WHERE fk_local_user = :user_id;";
            /* SQL - Params */
            $get_user_roles_query_params = array(':user_id' => $user_id);
            /* SQL - Exec */
            try {
                $get_user_roles_query_stmt = $this->DAO->ServiceDAO->prepare($get_user_roles_query);
                $get_user_roles_query_stmt->execute($get_user_roles_query_params);
            } catch (PDOException $ex) {
                $this->ClassActions->setStatus(false);
                $this->ClassActions->setStatusCode("get_user_roles_query_stmt");
                $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
                $this->ClassActions->setLine($ex->getLine());
            }
            /* SQL - Process Results */
            if ($this->ClassActions->getStatus()) {
                /* SQL - Result(s) */
                $get_user_roles_query_row = $get_user_roles_query_stmt->fetch();
                if ($get_user_roles_query_row) {
                    $this->setUserRoles($get_user_roles_query_row);
                } else {
                    $this->ClassActions->setStatus(false);
                    $this->ClassActions->setStatusCode("User not assigned any roles");
                }
            }
        }
        return $this->ClassActions;
    }

    private function setUserDetails($get_user_details_query_row)
    {
        if ($get_user_details_query_row) {
            $this->setID($get_user_details_query_row['id_local_user']);
            $this->setUserName($get_user_details_query_row['username']);
            $this->setName($get_user_details_query_row['firstname']);
            $this->setSurname($get_user_details_query_row['lastname']);
            $this->passwordsalt = $get_user_details_query_row['password'];
            $this->setSiteID($get_user_details_query_row['fk_site']);
            $this->setSiteName($get_user_details_query_row['site_name']);
            $this->setUserRoleName($get_user_details_query_row['role_name']);
            $this->setUserRole($get_user_details_query_row['fk_user_role']);
            $this->setAccValKey($get_user_details_query_row['account_val_key']);

            $this->unpackAuthSalt();
            $this->unpackPassword();

            $this->user_create_date = $get_user_details_query_row['account_create'];
            $this->account_status = $get_user_details_query_row['fk_user_status'];

            $this->user_status = ucwords($get_user_details_query_row['status_name']);
        } else {
            $this->ClassActions->setStatus(false);
            $this->ClassActions->setStatusCode("No such user");
            $this->configuration->LogBasicEntry(2, get_class($this->DAO), $this->ClassActions->getStatusStr(), $this->ClassActions->getStatusCode(), $this->ClassActions->getExtendedStatusCode(), $this->ClassActions->getLine());
        }
    }

    /**
     * 
     * @param integer $edit_user_id
     * @param integer $edit_user_site_id
     * @param integer $altered_user_id
     * @param integer $altered_user_site_id
     * @param string $action
     * @param string $msg
     * @return \voStatus
     */
    function DAOUserAlterAudit($edit_user_id, $edit_user_site_id, $altered_user_id, $altered_user_site_id, $action, $msg)
    {
        if (!$this->DAO->ServiceDAO) {
            $this->ClassActions = $this->DAO->initDAO();
        }
        if ($this->DAO->DAO_status->getStatus()) {
            /* SQL - Query */
            $insert_user_alter_audit_query = "INSERT INTO tbl_base_local_user_alterations(fk_local_user,
                                                                                          fk_local_user_site,
                                                                                          fk_local_user_altered,
                                                                                          fk_local_user_altered_site,
                                                                                          altered_action,
                                                                                          altered_msg,
                                                                                          fk_current_site)
                                              VALUES (:fk_local_user,
                                                      :fk_local_user_site,
                                                      :fk_local_user_altered,
                                                      :fk_local_user_altered_site,
                                                      :altered_action,
                                                      :altered_msg,
                                                      :fk_current_site);";
            /* SQL - Params */
            $insert_user_alter_audit_query_params = array(
                ':fk_local_user' => $edit_user_id,
                ':fk_local_user_site' => $edit_user_site_id,
                ':fk_local_user_altered' => $altered_user_id,
                ':fk_local_user_altered_site' => $altered_user_site_id,
                ':altered_action' => $action,
                ':altered_msg' => $msg,
                ':fk_current_site' => $this->configuration->getSiteID()
            );
            /* SQL - Exec */
            try {
                $insert_user_alter_audit_query_stmt = $this->DAO->ServiceDAO->prepare($insert_user_alter_audit_query);
                $insert_user_alter_audit_query_stmt->execute($insert_user_alter_audit_query_params);
            } catch (PDOException $ex) {
                $this->ClassActions->setStatus(false);
                $this->ClassActions->setStatusCode("insert_user_alter_audit_query_stmt");
                $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
                $this->ClassActions->setLine($ex->getLine());
                $this->configuration->LogBasicEntry(3, get_class($this->DAO), $this->ClassActions->getStatusStr(), $this->ClassActions->getStatusCode(), $this->ClassActions->getExtendedStatusCode(), $this->ClassActions->getLine());
            }
        }
        return $this->ClassActions;
    }

    /**
     * 
     * @param integer $user_id This uses the supplied var to get the user's details from the database.
     */
    function DAOGetUserDetails($user_id)
    {
        if (!$this->DAO->ServiceDAO) {
            $this->ClassActions = $this->DAO->initDAO();
        }
        if ($this->DAO->DAO_status->getStatus()) {
            /* SQL - Query */

            $get_user_details_query = "SELECT a.id_local_user,
                                              a.fk_site,
                                              a.username,
                                              a.password,
                                              a.fk_user_status,
                                              a.account_expiry,
                                              a.account_create,
                                              a.firstname,
                                              a.lastname,
                                              b.name AS 'status_name',
                                              b.description AS 'status_description',
                                              a.fk_user_role,
                                              a.account_val_key,
                                              c.name AS 'site_name',
                                              d.name AS 'role_name',
                                              d.description AS 'role_description'
                                       FROM tbl_base_local_users a,
                                            tbl_user_status b,
                                            tbl_base_sites c,
                                            tbl_base_user_roles d
                                       WHERE     a.id_local_user = :user_id
                                             AND a.fk_user_status = b.id_user_status
                                             AND a.fk_site = c.id_site
                                             AND a.fk_user_role = d.id_user_role;";
            /* SQL - Params */
            $get_user_details_query_params = array(':user_id' => $user_id);
            /* SQL - Exec */
            try {
                $get_user_details_query_stmt = $this->DAO->ServiceDAO->prepare($get_user_details_query);
                $get_user_details_query_stmt->execute($get_user_details_query_params);
            } catch (PDOException $ex) {
                $this->ClassActions->setStatus(false);
                $this->ClassActions->setStatusCode("get_user_details_query_stmt");
                $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
                $this->ClassActions->setLine($ex->getLine());
                $this->configuration->LogBasicEntry(3, get_class($this->DAO), $this->ClassActions->getStatusStr(), $this->ClassActions->getStatusCode(), $this->ClassActions->getExtendedStatusCode(), $this->ClassActions->getLine());
            }
            /* SQL - Process Results */
            if ($this->ClassActions->getStatus()) {
                /* SQL - Result(s) */
                $get_user_details_query_row = $get_user_details_query_stmt->fetch();
                $this->setUserDetails($get_user_details_query_row);
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
     * @return \voStatus
     */
    function DAOUserAudit($sessionID, $level, $action, $area, $msg)
    {
        if (!$this->DAO->ServiceDAO) {
            $this->ClassActions = $this->DAO->initDAO();
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
                $insert_user_audit_query_stmt = $this->DAO->ServiceDAO->prepare($insert_user_audit_query);
                $insert_user_audit_query_stmt->execute($insert_user_audit_query_params);
            } catch (PDOException $ex) {
                $this->ClassActions->setStatus(false);
                $this->ClassActions->setStatusCode("role_clean_stmt");
                $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
                $this->ClassActions->setLine($ex->getLine());
            }
        }
        return $this->ClassActions;
    }

//
//    /**
//     * 
//     * @param array $roles This contains the list of roles that the user is meant to be assigned
//     * @param boolean $keep_main This indicates if the exiting roles should be kept
//     * @return \voStatus
//     */
//    function DAOUpdateUserRoles($roles, $keep_main = true)
//    {
//        if (!$this->DAO->ServiceDAO) {
//            $this->ClassActions = $this->DAO->initDAO();
//        }
//        if ($this->ClassActions->getStatus()) {
//            /* SQL - Query */
//            if ($keep_main) {
//                $role_clean_query = "DELETE FROM tbl_ae_user_roles WHERE fk_user = :fk_user and fk_role <> 7;";
//            } else {
//                $role_clean_query = "DELETE FROM tbl_ae_user_roles WHERE fk_user = :fk_user;";
//            }
//            /* SQL - Params */
//            $role_clean_params = array(
//                ':fk_user' => $this->getID()
//            );
//            /* SQL - Exec */
//            try {
//                $role_clean_stmt = $this->DAO->ServiceDAO->prepare($role_clean_query);
//                $role_clean_stmt->execute($role_clean_params);
//            } catch (PDOException $ex) {
//                $this->ClassActions->setStatus(false);
//                $this->ClassActions->setStatusCode("role_clean_stmt");
//                $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
//                $this->ClassActions->setLine($ex->getLine());
//            }
//            if ($this->ClassActions->getStatus() && $roles) {
//                $items = count($roles);
//                for ($i = 0; $i < $items; $i++) {
//                    /* SQL - Query */
//                    $role_add_query = "INSERT INTO tbl_ae_user_roles(fk_user, fk_role) VALUES (:fk_user, :fk_role);";
//                    /* SQL - Params */
//                    $role_add_params = array(
//                        ':fk_user' => $this->getID(),
//                        ':fk_role' => $roles[$i]
//                    );
//                    /* SQL - Exec */
//                    try {
//                        $role_add_stmt = $this->DAO->ServiceDAO->prepare($role_add_query);
//                        $role_add_result = $role_add_stmt->execute($role_add_params);
//                    } catch (PDOException $ex) {
//                        $this->ClassActions->setStatus(false);
//                        $this->ClassActions->setStatusCode("role_add_stmt");
//                        $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
//                        $this->ClassActions->setLine($ex->getLine());
//                    }
//                }
//            }
//        }
//        return $this->ClassActions;
//    }

    function DAOUpdateAccountStatus($status)
    {
        if (!$this->DAO->ServiceDAO) {
            $this->ClassActions = $this->DAO->initDAO();
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
                $update_account_status_query_stmt = $this->DAO->ServiceDAO->prepare($update_account_status_query);
                $update_account_status_query_stmt->execute($update_account_status_query_params);
            } catch (PDOException $ex) {
                $this->ClassActions->setStatus(false);
                $this->ClassActions->setStatusCode("update_account_status_query_stmt");
                $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
                $this->ClassActions->setLine($ex->getLine());
            }
        }
        return $this->ClassActions;
    }

    function DAOAddInitRoles($user_id, $site_id, $role_id)
    {
        if (!$this->DAO->ServiceDAO) {
            $this->ClassActions = $this->DAO->initDAO();
        }
        if ($this->ClassActions->getStatus()) {
            /* SQL - Query */
            $insert_init_user_role_query = "INSERT INTO tbl_ae_local_users_roles_sites(fk_local_user, fk_site, fk_user_role) VALUES (:fk_local_user, :fk_site, :fk_user_role);";
            /* SQL - Params  */
            $insert_init_user_role_query_params = array(
                ':fk_local_user' => $user_id,
                ':fk_site' => $site_id,
                ':fk_user_role' => $role_id
            );
            /* SQL - Exec */
            try {
                $insert_init_user_role_query_stmt = $this->DAO->ServiceDAO->prepare($insert_init_user_role_query);
                $insert_init_user_role_query_stmt->execute($insert_init_user_role_query_params);
            } catch (PDOException $ex) {
                $this->ClassActions->setStatus(false);
                $this->ClassActions->setStatusCode("insert_init_user_role_stmt");
                $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
                $this->ClassActions->setLine($ex->getLine());
            }
        }
        return $this->ClassActions;
    }

    function DAOClearInitRoles($user_id, $site_id, $role_id)
    {
        if (!$this->DAO->ServiceDAO) {
            $this->ClassActions = $this->DAO->initDAO();
        }
        if ($this->ClassActions->getStatus()) {
            /* SQL - Query */
            $delete_init_user_role_query = "DELETE FROM tbl_ae_local_users_roles_sites
                                            WHERE     fk_local_user = :fk_local_user
                                                  AND fk_site = :fk_site
                                                  AND fk_user_role = :fk_user_role;";
            /* SQL - Params  */
            $delete_init_user_role_query_params = array(
                ':fk_local_user' => $user_id,
                ':fk_site' => $site_id,
                ':fk_user_role' => $role_id
            );
            /* SQL - Exec */
            try {
                $delete_init_user_role_query_stmt = $this->DAO->ServiceDAO->prepare($delete_init_user_role_query);
                $delete_init_user_role_query_stmt->execute($delete_init_user_role_query_params);
            } catch (PDOException $ex) {
                $this->ClassActions->setStatus(false);
                $this->ClassActions->setStatusCode("delete_init_user_role_stmt");
                $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
                $this->ClassActions->setLine($ex->getLine());
            }
        }
        return $this->ClassActions;
    }

    function DAOUpdateAccountPassword()
    {
        if (!$this->DAO->ServiceDAO) {
            $this->ClassActions = $this->DAO->initDAO();
        }
        if ($this->ClassActions->getStatus()) {
            $this->setPasswordSalt();
            /* SQL - Query */
            $update_account_password_query = "UPDATE tbl_base_local_users SET password = :password, fk_user_status = :fk_status, account_val_key = :account_val_key WHERE id_local_user = :id_user;";
            /* SQL - Params  */
            $update_account_password_query_params = array(
                ':id_user' => $this->getID(),
                ':fk_status' => $this->getAccountStatus(),
                ':password' => $this->getPasswordSalt(),
                ':account_val_key' => $this->getAccValKey()
            );
            /* SQL - Exec */
            try {
                $update_account_password_query_stmt = $this->DAO->ServiceDAO->prepare($update_account_password_query);
                $update_account_password_query_stmt->execute($update_account_password_query_params);
            } catch (PDOException $ex) {
                $this->ClassActions->setStatus(false);
                $this->ClassActions->setStatusCode("update_account_password_query_stmt");
                $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
                $this->ClassActions->setLine($ex->getLine());
            }
        }
        return $this->ClassActions;
    }

    /**
     * This function sets the settings that the SMTP phpmailer needs in order to do its thing.
     */
    private function SetMailerSettings()
    {
        $this->mail->mailer->isSMTP();
        $this->mail->mailer->SMTPDebug = 1;
        $this->mail->mailer->Debugoutput = 'error_log';
        $this->mail->mailer->Host = $this->mailer_settings->getSMTPHost();
        $this->mail->mailer->Port = $this->mailer_settings->getSMTPPort();
        $this->mail->mailer->SMTPSecure = $this->mailer_settings->getSMTPSecure();
        $this->mail->mailer->SMTPAuth = true;
        $this->mail->mailer->Username = $this->mailer_settings->getSMTPUsername();
        $this->mail->mailer->Password = $this->mailer_settings->getSMTPPassword();
        $this->mail->mailer->Timeout = 5;
        $this->mail->mailer->AltBody = 'This is a plain-text message body';
    }

    /**
     * Populate the invite email
     */
    public function setInviteEmailTemplate()
    {
        $this->email_template = file_get_contents($this->configuration->getTemplatePath() . "invite.template.html");
        $this->email_msg = str_replace(
            array(
            "{sitename}",
            "{name}",
            "{surname}",
            "{username}",
            "{usrurl}",
            "{bwcfwadminemail}"
            ), array(
            $this->configuration->getShortSiteName(),
            $this->getName(),
            $this->getSurname(),
            $this->getUserName(),
            $this->usrurl,
            $this->configuration->getBWCFWAdmineMail()
            ), $this->email_template);
    }

    /**
     * 
     * @param integer $id The ID of the user
     */
    function initUser($id)
    {
        $this->ClassActions = $this->DAO->initDAO();
        if ($this->ClassActions->getStatus()) {
            $this->DAOGetUserDetails($id);
//            if ($this->DAO->DAO_status->getStatus()) {
            //              $this->DAOGetUserDetails($id);
//            }
        } else {
            $this->configuration->LogBasicEntry(3, get_class($this->DAO), $this->ClassActions->getStatusStr(), $this->ClassActions->getStatusCode(), $this->ClassActions->getExtendedStatusCode(), $this->ClassActions->getLine());
        }
    }

    /**
     * This function sends an email to the user letting them know that an account has been created for them
     */
    function sendInviteEmail()
    {
        $this->mail->addAddress($this->getUserName());
        $this->mail->Subject = $this->configuration->getShortSiteName() . " - a user account has been created on your behalf";
        $this->mail->addReplyTo($this->mailer_settings->getNoreplyAddress(), $this->mailer_settings->getNoreplyName());
        if ($this->getSiteID() === '1') {
            $this->usrurl = $this->configuration->getBaseURLInternal() . "/pm/auth/account_activate.php?user=" . $this->getUserName() . "&verify=" . $this->acc_val_key;
        } else {
            $this->usrurl = $this->configuration->getBaseURL() . "/pm/auth/account_activate.php?user=" . $this->getUserName() . "&verify=" . $this->acc_val_key;
        }
        $this->setInviteEmailTemplate();
        $this->mail->msgHTML($this->email_msg);
        $fn = $this->configuration->getEmailsPath() . "/account_activation." . microtime() . ".html";
        file_put_contents($fn, $this->email_msg);
    }

    public function setUserSession()
    {
        $_SESSION["username"] = $this->getUserName();
        $_SESSION["id"] = $this->getID();
        $_SESSION["display_name"] = $this->getName();
        $_SESSION["firstName"] = $this->getName();
        $_SESSION["lastName"] = $this->getSurname();
        $_SESSION["join_date"] = $this->getUserCreateDate();
        $_SESSION["acc_status"] = $this->getStatusName();
        $_SESSION["site_id"] = $this->getSiteID();
        $_SESSION["site_name"] = $this->getSiteName();
        $_SESSION["roles"] = $this->getUserRoles();
        $_SESSION["role_name"] = $this->getUserRoleName();
    }

    function __construct($user_id = null)
    {
        /* Records */
//        $this->configuration = new LoggingService(false, false, false, true);
        $this->configuration = new LoggingService();
        $this->mailer_settings = new voSMTP();
        $this->ClassActions = new voStatus();
        $this->DAO = new ServiceDAO(false);
        /* Mailer */
        $this->mail = new ServiceEmailer();
        $this->SetMailerSettings();
        /* If there is a populated $user_id then get the details for that */
        if ($user_id) {
            $this->initUser($user_id);
        }
    }
}
