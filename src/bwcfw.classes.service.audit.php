<?php

class auditService extends LoggingService
{

    /**
     *
     * @var \PDO 
     */
    var $cdb;

    /**
     *
     * @var \$_SERVER 
     */
    var $ServerArray;

    /**
     *
     * @var \voStatus 
     */
    private $ClassActions;

    /**
     * Get the server and execution environment information
     */
    function setServerEnvironment($value)
    {
        $this->ServerArray = $value;
    }

    /**
     * 
     * @return array Return the server and execution environment information
     */
    function getServerEnvironment()
    {
        return $this->ServerArray;
    }

    /**
     * 
     * @return string Return the HTTP User Agent string
     */
    function getHTTPUserAgent()
    {
        return $this->ServerArray['HTTP_USER_AGENT'];
    }

    /**
     * 
     * @return string IP address of the user
     */
    function getClientIP()
    {
        if (isset($this->ServerArray)) {
            if (isset($this->ServerArray["HTTP_X_FORWARDED_FOR"])) {
                return $this->ServerArray["HTTP_X_FORWARDED_FOR"];
            }
            if (isset($this->ServerArray["HTTP_CLIENT_IP"])) {
                return $this->ServerArray["HTTP_CLIENT_IP"];
            }
            return $this->ServerArray["REMOTE_ADDR"];
        }
        if (getenv('HTTP_X_FORWARDED_FOR')) {
            return getenv('HTTP_X_FORWARDED_FOR');
        }
        if (getenv('HTTP_CLIENT_IP')) {
            return getenv('HTTP_CLIENT_IP');
        }
        return getenv('REMOTE_ADDR');
    }

    /**
     * This function initialises the DAO sub system
     */
    private function initDAO()
    {
        try {
            $this->cdb = new PDO("mysql:host={$this->database_settings->getHost()};dbname={$this->database_settings->getDataBase()};charset={$this->database_settings->getCharset()}", $this->database_settings->getUserName(), $this->database_settings->getPassword(), $this->database_settings->getDataBaseOptions());
        } catch (PDOException $ex) {
            $this->ClassActions->setStatus(false);
            $this->ClassActions->setStatusCode("init DAO");
            $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
            $this->ClassActions->setLine($ex->getLine());
            $this->LogBasicEntry(3, '{' . basename(__FILE__) . '} == ' . get_class($this->cdb), $this->ClassActions->getStatusStr(), $this->ClassActions->getStatusCode(), $this->ClassActions->getExtendedStatusCode(), $this->ClassActions->getLine());
        }
        if ($this->ClassActions->getStatus()) {
            $this->cdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->cdb->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->LogBasicEntry(2, '{' . basename(__FILE__) . '} == ' . get_class($this->cdb), $this->ClassActions->getStatusStr(), $this->ClassActions->getStatusCode(), $this->ClassActions->getExtendedStatusCode(), $this->ClassActions->getLine());
        }
    }

    /**
     * 
     * @param type $sessionID
     * @param type $level
     * @param type $action
     * @param type $area
     * @param type $msg

     */
    function DAOUserAudit($username, $user_id, $session_id, $user_ip, $section, $level, $area, $type, $action, $status, $msg, $browser_agent, $page, $extended_status, $line)
    {
        if ($this->cdb) {
            /* SQL - Query */
            $insert_user_audit_query = "INSERT INTO tbl_base_user_audit(username, username_id, session_id, user_ip, section, level, area, type, action, status, msg, browser_agent, page, extended_status, line, sid) VALUES (:username, :username_id, :session_id, :user_ip, :section, :level, :area, :type, :action, :status, :msg, :browser_agent, :page, :extended_status, :line, :sid);";
            /* SQL - Params */
            $insert_user_audit_query_params = array(
                ':username' => $username,
                ':username_id' => $user_id,
                ':session_id' => $session_id,
                ':user_ip' => $user_ip,
                ':section' => $section,
                ':level' => $level,
                ':type' => $type,
                ':area' => $area,
                ':action' => $action,
                ':status' => $status,
                ':msg' => $msg,
                ':browser_agent' => $browser_agent,
                ':page' => $page,
                ':extended_status' => $extended_status,
                ':line' => $line,
                ':sid' => microtime(true)
            );
            /* SQL - Exec */
            try {
                $insert_user_audit_query_stmt = $this->cdb->prepare($insert_user_audit_query);
                $insert_user_audit_query_stmt->execute($insert_user_audit_query_params);
            } catch (PDOException $ex) {
                $this->ClassActions->setStatus(false);
                $this->ClassActions->setStatusCode("insert_user_audit_query_stmt");
                $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
                $this->ClassActions->setLine($ex->getLine());
                $this->LogBasicEntry(3, '{' . basename(__FILE__) . '} == ' . get_class($this->cdb), $this->ClassActions->getStatusStr(), $this->ClassActions->getStatusCode(), $this->ClassActions->getExtendedStatusCode(), $this->ClassActions->getLine());
            }
            $this->LogBasicEntry(2, '{' . basename(__FILE__) . '} == ' . get_class($this->cdb), $this->ClassActions->getStatusStr(), $this->ClassActions->getStatusCode(), $this->ClassActions->getExtendedStatusCode(), $this->ClassActions->getLine());
        }
//        $this->LogBasicEntry((($this->ClassActions) ? 1 : 3), __FILE__, $this->ClassActions->getStatusStr(), $this->ClassActions->getStatusCode(), $this->ClassActions->getExtendedStatusCode(), $this->ClassActions->getLine());
        return $this->ClassActions;
    }

    /**
     * 
     * @param string $session This is the $_session array
     * @param string $action This indicate login/logout
     * @param string $sessionid This is the session_id() varible 
     */
    function DAOUserSession($session, $action, $sessionid)
    {
        if ($this->cdb) {
            /* SQL - Query */
            $insert_user_session_audit_query = "INSERT INTO tbl_base_sessions(session_id, username_id, username, firstname, surname, ip_remote_addr, action, browser_agent, sid) VALUES (:session_id, :username_id, :username, :firstname, :surname, :ip_remote_addr, :action, :browser_agent, :sid);";
            /* SQL - Params */
            $insert_user_session_audit_query_params = array(
                ':session_id' => $sessionid,
                ':username_id' => $session["id"],
                ':username' => $session["username"],
                ':firstname' => $session["firstName"],
                ':surname' => $session["lastName"],
                ':ip_remote_addr' => $this->getClientIP(),
                ':action' => $action,
                ':browser_agent' => $this->getHTTPUserAgent(),
                ':sid' => microtime(true)
            );
            /* SQL - Exec */
            try {
                $insert_user_session_audit_query_stmt = $this->cdb->prepare($insert_user_session_audit_query);
                $insert_user_session_audit_query_stmt->execute($insert_user_session_audit_query_params);
            } catch (PDOException $ex) {
                $this->ClassActions->setStatus(false);
                $this->ClassActions->setStatusCode("insert_user_session_audit_query");
                $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
                $this->ClassActions->setLine($ex->getLine());
            }
            $this->LogBasicEntry((($this->ClassActions) ? 2 : 3), '{' . basename(__FILE__) . '} == ' . get_class($this->cdb), $this->ClassActions->getStatusStr(), $this->ClassActions->getStatusCode(), $this->ClassActions->getExtendedStatusCode(), $this->ClassActions->getLine());
        }
        return $this->ClassActions;
    }

    function __construct($ServerArray = null)
    {
        parent::__construct();
        $this->database_settings = new voDAO();
        $this->ClassActions = new voStatus();
        $this->initDAO();
        $this->mailer_settings = new voSMTP();
        if ($ServerArray) {
            $this->setServerEnvironment($ServerArray);
        }
    }
}
