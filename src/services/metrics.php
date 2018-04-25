<?php

class ServiceMetrics extends LoggingService
{

    /**
     *
     * @var \ServiceDAO
     */
    private $serviceDAO;

    /**
     *
     * @var \voStatus
     */
    private $ClassActions;

    /**
     *
     * This function get the user's IP address based on the getenv('REMOTE_ADDR') value.
     * @return string This is the IP address that the user is currently using
     */
    private function getClientIP()
    {
        return getenv('REMOTE_ADDR');
    }

    /**
     *
     * @param array $array Array to be searched
     * @param string $arrayitem Named array item
     * @param string $value Value to match in array
     * @return boolean If result found then true
     */
    private function isValueInArray($array, $arrayitem, $value)
    {
        foreach ($array as $item) {
            if (strtoupper(strval($item[$arrayitem])) == strtoupper($value)) {
                return true;
            }
            if (strtoupper(strval($item[$arrayitem])) == "ADMIN") {
                return true;
            }
        }
        return false;
    }

    /**
     *
     * @param string $email_type
     * @param string $email_to
     * @param string $email_cc
     * @param string $email_bcc
     * @param string $email_size
     * @param string $email_status
     * @param string $email_extended_data
     * @return \voStatus
     */
    public function loadMetricsEmail($email_type, $email_to, $email_cc, $email_bcc, $email_size, $email_status, $email_extended_data)
    {
        if ($this->serviceDAO->getDAOStatus()) {
            /* SQL - Query */
            $metrics_email_query = "
	INSERT INTO tbl_base_metric_emails(email_type, email_to, email_cc, email_bcc, email_size, email_status, email_extended_data, sid)
	VALUES (:email_type, :email_to, :email_cc, :email_bcc, :email_size, :email_status, :email_extended_data, :sid);";
            /* SQL - Params */
            $metrics_email_query_params = array(
                ':email_type' => $email_type,
                ':email_to' => $email_to,
                ':email_cc' => $email_cc,
                ':email_bcc' => $email_bcc,
                ':email_size' => $email_size,
                ':email_status' => $email_status,
                ':email_extended_data' => $email_extended_data,
                ':sid' => microtime(true)
            );
            /* SQL - Exec */
            try {
                $metrics_email_stmt = $this->serviceDAO->ServicePDO->prepare($metrics_email_query);
                $metrics_email_stmt->execute($metrics_email_query_params);
            } catch (PDOException $e) {
                $this->ClassActions->setStatus(false);
                $this->ClassActions->setStatusCode($e->getMessage());
                $this->ClassActions->setExtendedStatusCode("Sub function located in " . $e->getFile());
                $this->ClassActions->setLine($e->getLine());
            }
        } else {
            $this->ClassActions->setStatus($this->serviceDAO->getDAOStatus());
            $this->ClassActions->setStatusCode($this->serviceDAO->getDAOStatusCode());
        }
        $this->LogBasicEntry((($this->classStatus->getStatus()) ? 1 : 3), get_class($this->serviceDAO), $this->classStatus->getStatusStr(), $this->classStatus->getStatusCode(), $this->classStatus->getExtendedStatusCode(), $this->classStatus->getLine());
        return $this->ClassActions;
    }

    /**
     *
     * @param string $audit_username
     * @param string $audit_user_id
     * @param string $audit_level
     * @param string $audit_action
     * @param string $audit_area
     * @param string $audit_msg
     * @param string $page
     * @param string $status
     * @param string $extended_status
     * @return \voStatus
     */
    public function loadUserAudit($audit_username, $audit_user_id, $audit_level, $audit_action, $audit_area, $audit_msg, $page, $status, $extended_status = "-")
    {
        if ($this->serviceDAO->getDAOStatus()) {
            /* Check username */
            if ($audit_username) {
                $currentuser = $audit_username;
            } else {
                $currentuser = "no_user_logged_in";
            }
            /* Check user ID */
            if ($audit_user_id) {
                $user_id = $audit_user_id;
            } else {
                $user_id = "no_user_id";
            }
            /* SQL - Query */
            $user_audit_query = "
	INSERT INTO tbl_base_loadUserAudit(username, username_id, session_id, user_ip, level, area, action, msg, browser_agent, sid, page, extended_status, status)
	VALUES (:username, :username_id, :session_id, :userip, :level, :area, :action, :msg, :browser_agent, :sid, :page, :extended_status, :status);";
            /* SQL - Params */
            $user_audit_query_params = array(
                ':username' => $currentuser,
                ':username_id' => $user_id,
                ':session_id' => session_id(),
                ':browser_agent' => $_SERVER['HTTP_USER_AGENT'],
                ':userip' => $this->getClientIP(),
                ':level' => $audit_level,
                ':area' => $audit_area,
                ':action' => $audit_action,
                ':msg' => $audit_msg,
                ':sid' => microtime(true),
                ':page' => $page,
                ':extended_status' => $extended_status,
                ':status' => $status
            );

            /* SQL - Exec */
            try {
                $user_audit_stmt = $this->serviceDAO->ServicePDO->prepare($user_audit_query);
                $user_audit_stmt->execute($user_audit_query_params);
            } catch (PDOException $e) {
                $this->ClassActions->setStatus(false);
                $this->ClassActions->setStatusCode($e->getMessage());
                $this->ClassActions->setExtendedStatusCode("Sub function located in " . $e->getFile());
                $this->ClassActions->setLine($e->getLine());
            }
        } else {
            $this->ClassActions->setStatus($this->serviceDAO->getDAOStatus());
            $this->ClassActions->setStatusCode($this->serviceDAO->getDAOStatusCode());
        }
        $this->LogBasicEntry((($this->classStatus->getStatus()) ? 1 : 3), get_class($this->serviceDAO), $this->classStatus->getStatusStr(), $this->classStatus->getStatusCode(), $this->classStatus->getExtendedStatusCode(), $this->classStatus->getLine());
        return $this->ClassActions;
    }

    public function __construct()
    {
        parent::__construct();
        $this->serviceDAO = new ServiceDAO();
        $this->ClassActions = new voStatus();
    }
}
